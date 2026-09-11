@extends('Layout.app')
@section('title', 'Dashboard')
@section('main')

@auth
    @if(auth()->user()->isCustomer())
        @php
            $dueNow = \App\Models\LoanSchedule::whereHas('loan', function ($q) {
                $q->where('customer_id', auth()->id());
            })
                ->with('loan')
                ->whereIn('status', ['Pending', 'Overdue'])
                ->whereDate('due_date', '<=', now()->toDateString())
                ->orderBy('due_date')
                ->get();
        @endphp

        @if ($dueNow->isNotEmpty())
            <div class="alert alert-danger alert-dismissible fade show shadow mb-4" role="alert">
                <div class="d-flex align-items-start gap-3">
                    <div class="fs-2 lh-1">🔔</div>
                    <div class="flex-grow-1">
                        <h5 class="fw-bold mb-3">ការជូនដំណឹង — ត្រូវបង់ប្រាក់!</h5>

                        {{-- One row per due installment --}}
                        <div class="d-flex flex-column gap-2">
                            @foreach ($dueNow as $due)
                                @php $isToday = $due->due_date->isToday(); @endphp
                                <div class="d-flex align-items-center flex-wrap gap-2 py-2 border-bottom border-danger border-opacity-25">
                                    <div class="flex-grow-1">
                                        <span class="badge {{ $isToday ? 'bg-warning text-dark' : 'bg-danger' }} me-1">
                                            {{ $isToday ? 'ថ្ងៃនេះ!' : 'ហួសថ្ងៃ' }}
                                        </span>
                                        <strong>កម្ចី #{{ $due->loan_id }}</strong>
                                        — លើកទី {{ $due->installment_no }}
                                        — ថ្ងៃ {{ $due->due_date->format('d/m/Y') }}
                                        — <span class="fw-bold text-danger">${{ number_format($due->total_due, 2) }}</span>
                                    </div>
                                    {{-- Direct button to this loan's schedule --}}
                                    <a href="{{ route('loans.schedule', $due->loan) }}"
                                       class="btn {{ $isToday ? 'btn-warning' : 'btn-danger' }} btn-sm fw-semibold">
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

        <div class="card shadow-sm">
            <div class="card-body text-center py-5">
                <i class="bi bi-wallet2 fs-1 text-primary mb-3 d-block"></i>
                <h5 class="fw-semibold">សូមស្វាគមន៍, {{ auth()->user()->name }}!</h5>
                <p class="text-muted mb-3">ចូលមើលប្រាក់កម្ចីរបស់លោកអ្នក ឬស្នើសុំកម្ចីថ្មី។</p>
                <div class="d-flex gap-2 justify-content-center">
                    <a href="{{ route('loans.my_loans') }}" class="btn btn-primary">
                        <i class="bi bi-wallet2 me-1"></i> ប្រាក់កម្ចីរបស់ខ្ញុំ
                    </a>
                    <a href="{{ route('loans.apply') }}" class="btn btn-outline-primary">
                        <i class="bi bi-file-earmark-plus me-1"></i> ស្នើសុំកម្ចីថ្មី
                    </a>
                </div>
            </div>
        </div>

    @else
        <div class="card shadow-sm">
            <div class="card-body text-center py-5">
                <i class="bi bi-speedometer fs-1 text-secondary mb-3 d-block"></i>
                <h5 class="fw-semibold">សូមស្វាគមន៍មកកាន់ប្រព័ន្ធ!</h5>
                <p class="text-muted">ប្រើ sidebar ខាងឆ្វេង ដើម្បីចូលទៅកាន់ menu ដែលអ្នកចង់ប្រើ។</p>
            </div>
        </div>
    @endif
@endauth

@endsection