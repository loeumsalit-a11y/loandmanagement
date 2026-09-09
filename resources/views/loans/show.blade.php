@extends('Layout.app')
@section('title', 'ព័ត៌មានលម្អិតប្រាក់កម្ចី')
@section('main')

<div class="row g-3">
    {{-- Loan Info --}}
    <div class="col-md-5">
        <div class="card shadow-sm h-100">
            <div class="card-header">
                <h3 class="card-title"><i class="bi bi-info-circle me-2"></i>ព័ត៌មានប្រាក់កម្ចី</h3>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless">
                    <tr>
                        <td class="text-muted">អតិថិជន</td>
                        <td><strong>{{ $loan->customer->name }}</strong></td>
                    </tr>
                    <tr>
                        <td class="text-muted">អ៊ីម៉ែល</td>
                        <td>{{ $loan->customer->email }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">ប្រាក់ដើម</td>
                        <td><strong>${{ number_format($loan->principal_amount, 2) }}</strong></td>
                    </tr>
                    <tr>
                        <td class="text-muted">អត្រាការប្រាក់/ខែ</td>
                        <td>{{ $loan->interest_rate }}%</td>
                    </tr>
                    <tr>
                        <td class="text-muted">រយៈពេល</td>
                        <td>{{ $loan->term_months }} ខែ</td>
                    </tr>
                    <tr>
                        <td class="text-muted">ថ្ងៃបើកប្រាក់</td>
                        <td>{{ $loan->disbursement_date ? $loan->disbursement_date->format('d/m/Y') : '—' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">ស្ថានភាព</td>
                        <td>
                            @php
                                $badgeClass = match($loan->status) {
                                    'Pending'   => 'bg-secondary',
                                    'Approved'  => 'bg-info',
                                    'Disbursed' => 'bg-success',
                                    'Rejected'  => 'bg-danger',
                                    default     => 'bg-dark',
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ $loan->status }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">សមតុល្យនៅសល់</td>
                        <td>
                            <strong class="text-danger fs-5">
                                ${{ $loan->remaining_balance }}
                            </strong>
                        </td>
                    </tr>
                </table>

                <div class="mt-3 d-flex gap-2 flex-wrap">
                    <a href="{{ route('loans.schedule', $loan) }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-calendar3 me-1"></i> កាលវិភាគ
                    </a>
                    @can('repay', $loan)
                        @if ($loan->status === 'Disbursed')
                            <a href="{{ route('loans.repay', $loan) }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-credit-card me-1"></i> កត់ការបង់ប្រាក់
                            </a>
                        @endif
                    @endcan
                </div>
            </div>
        </div>
    </div>

    {{-- Repayment History --}}
    <div class="col-md-7">
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="card-title"><i class="bi bi-clock-history me-2"></i>ប្រវត្តិការបង់ប្រាក់</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>ថ្ងៃបង់</th>
                                <th>លើកទី</th>
                                <th class="text-end">ទឹកប្រាក់ ($)</th>
                                <th>វិធីសាស្ត្រ</th>
                                <th>ទទួលដោយ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($repayments as $repayment)
                                <tr>
                                    <td>{{ $repayment->payment_date->format('d/m/Y') }}</td>
                                    <td>{{ $repayment->schedule->installment_no }}</td>
                                    <td class="text-end text-success fw-semibold">
                                        ${{ number_format($repayment->amount_paid, 2) }}
                                    </td>
                                    <td>{{ $repayment->payment_method }}</td>
                                    <td>{{ $repayment->receiver->name }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-3">
                                        <i class="bi bi-inbox d-block fs-4 mb-1"></i>
                                        គ្មានប្រវត្តិការបង់ប្រាក់
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
