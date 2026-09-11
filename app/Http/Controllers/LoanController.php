<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\LoanSchedule;
use App\Models\LoanSetting;
use App\Models\Repayment;
use App\Services\AmortizationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class LoanController extends Controller
{
    public function __construct(private AmortizationService $amortization) {}

    // ==============================
    // Customer: ដាក់ពាក្យស្នើសុំ
    // ==============================

    public function applyForm(): View
    {
        $defaultInterestRate = LoanSetting::get('default_interest_rate', 2.0);

        return view('loans.apply', compact('defaultInterestRate'));
    }

    public function apply(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'principal_amount' => ['required', 'numeric', 'min:1'],
            'term_months' => ['required', 'integer', 'min:1', 'max:360'],
        ]);

        Loan::create([
            'customer_id' => auth()->id(),
            'principal_amount' => $validated['principal_amount'],
            'interest_rate' => LoanSetting::get('default_interest_rate', 2.0),
            'term_months' => $validated['term_months'],
            'status' => 'Pending',
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('loans.my_loans')->with('success', 'ពាក្យស្នើសុំប្រាក់កម្ចីបានដាក់ជូនដោយជោគជ័យ!');
    }

    // ==============================
    // Staff (Admin, Officer, Cashier): មើលប្រាក់កម្ចីទាំងអស់
    // ==============================

    public function index(): View
    {
        $loans = Loan::with('customer')
            ->latest()
            ->paginate(15);

        return view('loans.index', compact('loans'));
    }

    // ==============================
    // Admin/LoanOfficer: មើល Pending
    // ==============================

    public function pendingList(): View
    {
        $loans = Loan::with('customer')
            ->where('status', 'Pending')
            ->latest()
            ->paginate(10);

        return view('loans.pending', compact('loans'));
    }

    // ==============================
    // Admin/LoanOfficer: អនុម័ត
    // ==============================

    public function approve(Loan $loan): RedirectResponse
    {
        Gate::authorize('approve', $loan);

        if ($loan->status !== 'Pending') {
            return back()->with('error', 'ប្រាក់កម្ចីនេះមិនស្ថិតក្នុងស្ថានភាព Pending ទេ។');
        }

        $loan->update(['status' => 'Approved']);

        return redirect()->route('loans.pending')->with('success', 'ប្រាក់កម្ចីបានអនុម័តដោយជោគជ័យ!');
    }

    // ==============================
    // Admin: បើកប្រាក់ + Generate Schedule
    // ==============================

    public function disburse(Loan $loan): RedirectResponse
    {
        Gate::authorize('disburse', $loan);

        if ($loan->status !== 'Approved') {
            return back()->with('error', 'ប្រាក់កម្ចីនេះត្រូវបានអនុម័តជាមុនសិន។');
        }

        $disbursementDate = now()->toDateString();

        DB::transaction(function () use ($loan, $disbursementDate) {
            $loan->update([
                'status' => 'Disbursed',
                'disbursement_date' => $disbursementDate,
            ]);

            $schedule = $this->amortization->generate(
                $loan->principal_amount,
                $loan->interest_rate,
                $loan->term_months,
                $disbursementDate
            );

            foreach ($schedule as $row) {
                LoanSchedule::create(array_merge(['loan_id' => $loan->id], $row, ['status' => 'Pending']));
            }
        });

        return redirect()->route('loans.schedule', $loan)->with('success', 'ប្រាក់កម្ចីបានបើកប្រាក់ ហើយកាលវិភាគបានបង្កើតដោយជោគជ័យ!');
    }

    // ==============================
    // បង្ហាញ Amortization Schedule
    // ==============================

    public function schedule(Loan $loan): View
    {
        Gate::authorize('view', $loan);

        $schedules = $loan->schedules()->with('repayments')->get();

        return view('loans.schedule', compact('loan', 'schedules'));
    }

    // ==============================
    // Cashier: Form + Process Repayment
    // ==============================

    public function repayForm(Loan $loan): View
    {
        Gate::authorize('repay', $loan);

        $nextSchedule = $loan->schedules()
            ->whereIn('status', ['Pending', 'Overdue'])
            ->orderBy('installment_no')
            ->first();

        return view('loans.repay', compact('loan', 'nextSchedule'));
    }

    public function repay(Request $request, Loan $loan): RedirectResponse
    {
        Gate::authorize('repay', $loan);

        $validated = $request->validate([
            'amount_paid' => ['required', 'numeric', 'min:0.01'],
            'payment_method' => ['required', 'string', 'max:50'],
        ]);

        DB::transaction(function () use ($validated, $loan) {
            $remaining = (float) $validated['amount_paid'];

            $pendingSchedules = $loan->schedules()
                ->whereIn('status', ['Pending', 'Overdue'])
                ->orderBy('installment_no')
                ->get();

            foreach ($pendingSchedules as $schedule) {
                if ($remaining <= 0) {
                    break;
                }

                $toPay = min($remaining, (float) $schedule->total_due);

                Repayment::create([
                    'loan_id' => $loan->id,
                    'schedule_id' => $schedule->id,
                    'amount_paid' => $toPay,
                    'payment_date' => now()->toDateString(),
                    'payment_method' => $validated['payment_method'],
                    'received_by' => auth()->id(),
                ]);

                // Mark as Paid only when fully covered
                if ($toPay >= (float) $schedule->total_due) {
                    $schedule->update(['status' => 'Paid']);
                }

                $remaining -= $toPay;
            }
        });

        return redirect()->route('loans.schedule', $loan)->with('success', 'ការបង់ប្រាក់បានកត់ត្រាដោយជោគជ័យ!');
    }

    // ==============================
    // ព័ត៌មានលម្អិតប្រាក់កម្ចី
    // ==============================

    public function show(Loan $loan): View
    {
        Gate::authorize('view', $loan);

        $loan->load(['customer', 'schedules.repayments.receiver', 'creator']);
        $repayments = Repayment::where('loan_id', $loan->id)->with('receiver', 'schedule')->latest()->get();

        return view('loans.show', compact('loan', 'repayments'));
    }

    // ==============================
    // Admin: Overdue Dashboard
    // ==============================

    public function overdueDashboard(): View
    {
        $overdueSchedules = LoanSchedule::with(['loan.customer'])
            ->where('status', 'Overdue')
            ->orderBy('due_date')
            ->paginate(15);

        return view('dashboard.overdue', compact('overdueSchedules'));
    }

    // ==============================
    // Customer: បញ្ជីកម្ចីផ្ទាល់ខ្លួន
    // ==============================

    public function myLoans(): View
    {
        $loans = Loan::where('customer_id', auth()->id())
            ->latest()
            ->paginate(10);

        // Installments that are due today or overdue (for the alert banner)
        $dueAlerts = LoanSchedule::whereHas('loan', function ($q) {
            $q->where('customer_id', auth()->id());
        })
            ->with('loan')
            ->whereIn('status', ['Pending', 'Overdue'])
            ->whereDate('due_date', '<=', now()->toDateString())
            ->orderBy('due_date')
            ->get();

        return view('loans.my_loans', compact('loans', 'dueAlerts'));
    }
}
