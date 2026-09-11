<?php

namespace Database\Seeders;

use App\Models\Loan;
use App\Models\LoanSchedule;
use App\Models\User;
use App\Services\AmortizationService;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DemoLoanSeeder extends Seeder
{
    /**
     * Seed a demo disbursed loan for the Customer User account
     * with 2 overdue installments — ready for demo/video recording.
     */
    public function run(): void
    {
        $customer = User::where('email', 'customer@example.com')->firstOrFail();
        $admin = User::where('email', 'admin@example.com')->firstOrFail();

        // Disbursed 3 months ago so installments 1 & 2 are already overdue
        $disbursementDate = now()->subMonths(3)->toDateString();

        $loan = Loan::create([
            'customer_id' => $customer->id,
            'principal_amount' => 5000.00,
            'interest_rate' => 2.00,
            'term_months' => 12,
            'status' => 'Disbursed',
            'disbursement_date' => $disbursementDate,
            'created_by' => $admin->id,
        ]);

        // Generate full amortization schedule
        $amortization = app(AmortizationService::class);
        $schedule = $amortization->generate(
            principal: 5000.00,
            monthlyRate: 2.00,
            termMonths: 12,
            startDate: $disbursementDate,
        );

        foreach ($schedule as $row) {
            $dueDate = Carbon::parse($row['due_date']);

            // Mark installments 1 & 2 as Overdue (already past); rest remain Pending
            $status = $dueDate->isPast() ? 'Overdue' : 'Pending';

            LoanSchedule::create(array_merge(
                ['loan_id' => $loan->id],
                $row,
                ['status' => $status],
            ));
        }
    }
}
