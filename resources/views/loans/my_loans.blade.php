@extends('Layout.app')
@section('title', 'ប្រាក់កម្ចីរបស់ខ្ញុំ')
@section('main')

{{-- ===== Due / Overdue Alert Banner ===== --}}
@if ($dueAlerts->isNotEmpty())
    <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-3" role="alert">
        <div class="d-flex align-items-start gap-3">
            <div class="fs-3 lh-1">🔔</div>
            <div class="flex-grow-1">
                <h6 class="fw-bold mb-2">
                    មានការបង់ប្រាក់ចំនួន {{ $dueAlerts->count() }} លើក ត្រូវ​ចាំ​បង់!
                </h6>

                {{-- One row per due installment with direct schedule button --}}
                <div class="d-flex flex-column gap-2">
                    @foreach ($dueAlerts as $alert)
                        @php
                            $isToday = $alert->due_date->isToday();
                        @endphp
                        <div class="d-flex align-items-center flex-wrap gap-2 py-2 border-bottom border-danger border-opacity-25">
                            <div class="flex-grow-1">
                                <span class="badge {{ $isToday ? 'bg-warning text-dark' : 'bg-danger' }} me-1">
                                    {{ $isToday ? 'ថ្ងៃនេះ!' : 'ហួសថ្ងៃ' }}
                                </span>
                                <strong>កម្ចី #{{ $alert->loan_id }}</strong>
                                — លើកទី {{ $alert->installment_no }}
                                — ថ្ងៃ {{ $alert->due_date->format('d/m/Y') }}
                                — <span class="fw-bold text-danger">${{ number_format($alert->total_due, 2) }}</span>
                            </div>
                            <a href="{{ route('loans.schedule', $alert->loan) }}"
                               class="btn btn-sm {{ $isToday ? 'btn-warning' : 'btn-danger' }} fw-semibold">
                                <i class="bi bi-calendar3 me-1"></i> មើលកាលវិភាគ
                            </a>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- ===== Loan Table ===== --}}
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">
            <i class="bi bi-wallet2 me-2 text-primary"></i>ប្រាក់កម្ចីរបស់ខ្ញុំ
        </h3>
        <a href="{{ route('loans.apply') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-file-earmark-plus me-1"></i> ស្នើសុំកម្ចីថ្មី
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>កាលបរិច្ឆេទស្នើ</th>
                        <th>ប្រាក់ដើម ($)</th>
                        <th>អត្រា (%/ខែ)</th>
                        <th>រយៈពេល (ខែ)</th>
                        <th>ស្ថានភាព</th>
                        <th>ការបង់ប្រាក់</th>
                        <th class="text-center">សកម្មភាព</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($loans as $loan)
                        @php
                            $loanDue = $dueAlerts->where('loan_id', $loan->id)->first();
                        @endphp
                        <tr class="{{ $loanDue ? 'table-warning' : '' }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $loan->created_at->format('d/m/Y') }}</td>
                            <td>{{ number_format($loan->principal_amount, 2) }}</td>
                            <td>{{ $loan->interest_rate }}%</td>
                            <td>{{ $loan->term_months }} ខែ</td>
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
                            <td>
                                @if ($loanDue)
                                    <span class="badge {{ $loanDue->due_date->isToday() ? 'bg-warning text-dark' : 'bg-danger' }}">
                                        <i class="bi bi-bell-fill me-1"></i>
                                        {{ $loanDue->due_date->isToday() ? 'ត្រូវបង់ថ្ងៃនេះ' : 'ហួសថ្ងៃ' }}
                                        — ${{ number_format($loanDue->total_due, 2) }}
                                    </span>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($loan->status === 'Disbursed')
                                    {{-- If this loan has a due installment, highlight the schedule button --}}
                                    <a href="{{ route('loans.schedule', $loan) }}"
                                       class="btn btn-sm {{ $loanDue ? 'btn-warning' : 'btn-info' }}">
                                        <i class="bi bi-calendar3 me-1"></i> កាលវិភាគ
                                        @if ($loanDue)
                                            <span class="badge bg-danger ms-1">!</span>
                                        @endif
                                    </a>
                                @endif
                                <a href="{{ route('loans.show', $loan) }}" class="btn btn-secondary btn-sm ms-1">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                លោកអ្នកមិនទាន់មានប្រាក់កម្ចីនៅឡើយទេ។
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if ($loans->hasPages())
        <div class="card-footer">
            {{ $loans->links() }}
        </div>
    @endif
</div>

@endsection
