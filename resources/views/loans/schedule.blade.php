@extends('Layout.app')
@section('title', 'កាលវិភាគបង់ប្រាក់')
@section('main')

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h3 class="card-title mb-0">
            <i class="bi bi-calendar3 me-2 text-primary"></i>
            កាលវិភាគបង់ប្រាក់ — {{ $loan->customer->name }}
        </h3>
        <div class="d-flex gap-2">
            @can('disburse', $loan)
                @if ($loan->status === 'Approved')
                    <form action="{{ route('loans.disburse', $loan) }}" method="POST"
                        onsubmit="return confirm('បើកប្រាក់ហើយបង្កើតកាលវិភាគ?')">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="bi bi-cash-stack me-1"></i> បើកប្រាក់
                        </button>
                    </form>
                @endif
            @endcan
            @can('repay', $loan)
                @if ($loan->status === 'Disbursed')
                    <a href="{{ route('loans.repay', $loan) }}" class="btn btn-warning btn-sm">
                        <i class="bi bi-credit-card me-1"></i> កត់ការបង់ប្រាក់
                    </a>
                @endif
            @endcan
            <a href="{{ route('loans.show', $loan) }}" class="btn btn-info btn-sm">
                <i class="bi bi-eye me-1"></i> លម្អិត
            </a>
        </div>
    </div>

    {{-- Loan Summary --}}
    <div class="card-body border-bottom">
        <div class="row g-3">
            <div class="col-sm-3">
                <div class="text-muted small">ប្រាក់ដើម</div>
                <strong class="fs-5">${{ number_format($loan->principal_amount, 2) }}</strong>
            </div>
            <div class="col-sm-3">
                <div class="text-muted small">អត្រាការប្រាក់/ខែ</div>
                <strong class="fs-5">{{ $loan->interest_rate }}%</strong>
            </div>
            <div class="col-sm-3">
                <div class="text-muted small">រយៈពេល</div>
                <strong class="fs-5">{{ $loan->term_months }} ខែ</strong>
            </div>
            <div class="col-sm-3">
                <div class="text-muted small">ស្ថានភាព</div>
                @php
                    $badgeClass = match($loan->status) {
                        'Pending'  => 'bg-secondary',
                        'Approved' => 'bg-info',
                        'Disbursed'=> 'bg-success',
                        'Rejected' => 'bg-danger',
                        default    => 'bg-dark',
                    };
                @endphp
                <span class="badge {{ $badgeClass }} fs-6">{{ $loan->status }}</span>
            </div>
        </div>
    </div>

    {{-- Schedule Table --}}
    @if ($session_success = session('success'))
        <div class="alert alert-success m-3">{{ $session_success }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th class="text-center">លើកទី</th>
                    <th>ថ្ងៃបង់</th>
                    <th class="text-end">ប្រាក់ដើម ($)</th>
                    <th class="text-end">ការប្រាក់ ($)</th>
                    <th class="text-end">សរុប ($)</th>
                    <th class="text-center">ស្ថានភាព</th>
                    <th>ការបង់ប្រាក់</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($schedules as $schedule)
                    @php
                        $rowClass = match($schedule->status) {
                            'Overdue' => 'table-danger',
                            'Paid'    => 'table-success',
                            default   => '',
                        };
                        $badgeClass = match($schedule->status) {
                            'Overdue' => 'bg-danger',
                            'Paid'    => 'bg-success',
                            default   => 'bg-warning text-dark',
                        };
                    @endphp
                    <tr class="{{ $rowClass }}">
                        <td class="text-center fw-bold">{{ $schedule->installment_no }}</td>
                        <td>{{ $schedule->due_date->format('d/m/Y') }}</td>
                        <td class="text-end">{{ number_format($schedule->principal_due, 2) }}</td>
                        <td class="text-end">{{ number_format($schedule->interest_due, 2) }}</td>
                        <td class="text-end fw-semibold">{{ number_format($schedule->total_due, 2) }}</td>
                        <td class="text-center">
                            <span class="badge {{ $badgeClass }}">{{ $schedule->status }}</span>
                        </td>
                        <td>
                            @foreach ($schedule->repayments as $repayment)
                                <small class="d-block text-success">
                                    <i class="bi bi-check-circle-fill me-1"></i>
                                    ${{ number_format($repayment->amount_paid, 2) }}
                                    — {{ $repayment->payment_date->format('d/m/Y') }}
                                </small>
                            @endforeach
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="bi bi-inbox d-block fs-3 mb-2"></i>
                            មិនទាន់មានកាលវិភាគ — ត្រូវបើកប្រាក់ជាមុន
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
