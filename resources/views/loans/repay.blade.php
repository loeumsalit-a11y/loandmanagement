@extends('Layout.app')
@section('title', 'កត់ការបង់ប្រាក់')
@section('main')

{{-- Page Header --}}
<div class="d-flex align-items-center justify-content-between mb-3">
    <h4 class="mb-0 fw-semibold">
        <i class="bi bi-credit-card-2-front me-2 text-warning"></i>
        កត់ការបង់ប្រាក់
    </h4>
    <a href="{{ route('loans.schedule', $loan) }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> ត្រឡប់ទៅកាលវិភាគ
    </a>
</div>

{{-- Loan Summary Card --}}
<div class="card shadow-sm mb-3">
    <div class="card-header bg-light py-2">
        <span class="fw-semibold text-muted small">
            <i class="bi bi-person-circle me-1"></i> ព័ត៌មានប្រាក់កម្ចី
        </span>
    </div>
    <div class="card-body py-3">
        <div class="row g-3">
            <div class="col-6 col-sm-3">
                <div class="text-muted small mb-1">អតិថិជន</div>
                <div class="fw-semibold">{{ $loan->customer->name }}</div>
            </div>
            <div class="col-6 col-sm-3">
                <div class="text-muted small mb-1">ប្រាក់ដើម</div>
                <div class="fw-semibold">${{ number_format($loan->principal_amount, 2) }}</div>
            </div>
            <div class="col-6 col-sm-3">
                <div class="text-muted small mb-1">អត្រាការប្រាក់/ខែ</div>
                <div class="fw-semibold">{{ $loan->interest_rate }}%</div>
            </div>
            <div class="col-6 col-sm-3">
                <div class="text-muted small mb-1">រយៈពេល</div>
                <div class="fw-semibold">{{ $loan->term_months }} ខែ</div>
            </div>
        </div>
    </div>
</div>

{{-- Main Content --}}
<div class="row g-3">

    {{-- Left: Next Installment Info --}}
    <div class="col-md-5">
        @if ($nextSchedule)
            <div class="card shadow-sm h-100 border-0">
                <div class="card-header bg-warning bg-opacity-10 border-bottom border-warning border-opacity-25 py-2">
                    <span class="fw-semibold text-warning-emphasis">
                        <i class="bi bi-calendar-check me-1"></i>
                        វ៉ែនបង់ #{{ $nextSchedule->installment_no }}
                    </span>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">ថ្ងៃបង់:</span>
                            <span class="fw-semibold">
                                {{ $nextSchedule->due_date->format('d/m/Y') }}
                                @if ($nextSchedule->status === 'Overdue')
                                    <span class="badge bg-danger ms-1">មានបំណុល</span>
                                @endif
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">ប្រាក់ដើម:</span>
                            <span class="fw-semibold">${{ number_format($nextSchedule->principal_due, 2) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">ការប្រាក់:</span>
                            <span class="fw-semibold">${{ number_format($nextSchedule->interest_due, 2) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0 border-top border-2">
                            <span class="fw-bold">សរុបត្រូវបង់:</span>
                            <span class="fw-bold fs-5 text-danger">
                                ${{ number_format($nextSchedule->total_due, 2) }}
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        @else
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex flex-column align-items-center justify-content-center text-center py-5">
                    <i class="bi bi-check-circle-fill text-success fs-1 mb-3"></i>
                    <h6 class="fw-semibold text-success mb-1">ប្រាក់កម្ចីបានបង់ទាំងស្រុង!</h6>
                    <p class="text-muted small mb-0">គ្មានការបង់ប្រាក់ណានៅសល់ទៀតទេ។</p>
                </div>
            </div>
        @endif
    </div>

    {{-- Right: Payment Form --}}
    <div class="col-md-7">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-light py-2">
                <span class="fw-semibold text-muted small">
                    <i class="bi bi-pencil-square me-1"></i> បំពេញព័ត៌មានការបង់ប្រាក់
                </span>
            </div>
            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show py-2" role="alert">
                        <i class="bi bi-exclamation-triangle me-1"></i>
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if ($nextSchedule)
                    <form action="{{ route('loans.repay.store', $loan) }}" method="POST">
                        @csrf

                        {{-- Amount --}}
                        <div class="mb-3">
                            <label for="amount_paid" class="form-label fw-semibold">
                                ទឹកប្រាក់ <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input
                                    type="number"
                                    step="0.01"
                                    min="0.01"
                                    id="amount_paid"
                                    name="amount_paid"
                                    class="form-control form-control-lg @error('amount_paid') is-invalid @enderror"
                                    value="{{ old('amount_paid', number_format($nextSchedule->total_due, 2, '.', '')) }}"
                                    placeholder="{{ number_format($nextSchedule->total_due, 2) }}"
                                    required>
                                @error('amount_paid')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>
                                បង់លើស ${{ number_format($nextSchedule->total_due, 2) }} នឹងផ្ទេរទៅលើកបន្ទាប់ដោយស្វ័យប្រវត្តិ។
                            </div>
                        </div>

                        {{-- Payment Method --}}
                        <div class="mb-4">
                            <label for="payment_method" class="form-label fw-semibold">
                                វិធីសាស្ត្របង់ <span class="text-danger">*</span>
                            </label>
                            <select
                                id="payment_method"
                                name="payment_method"
                                class="form-select @error('payment_method') is-invalid @enderror"
                                required>
                                <option value="" disabled {{ old('payment_method') ? '' : 'selected' }}>— ជ្រើសរើស —</option>
                                <option value="Cash"     {{ old('payment_method') === 'Cash'     ? 'selected' : '' }}>
                                    💵 ក្រដាស (Cash)
                                </option>
                                <option value="Transfer" {{ old('payment_method') === 'Transfer' ? 'selected' : '' }}>
                                    🏦 ផ្ទេរ (Bank Transfer)
                                </option>
                                <option value="ABA"      {{ old('payment_method') === 'ABA'      ? 'selected' : '' }}>
                                    🔵 ABA Bank
                                </option>
                                <option value="Wing"     {{ old('payment_method') === 'Wing'     ? 'selected' : '' }}>
                                    🟠 Wing
                                </option>
                            </select>
                            @error('payment_method')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Actions --}}
                        <div class="d-grid gap-2 d-sm-flex">
                            <button type="submit" class="btn btn-warning btn-lg px-4"
                                onclick="return confirm('បញ្ជាក់ការបង់ប្រាក់ $' + document.getElementById('amount_paid').value + '?')">
                                <i class="bi bi-check-circle me-1"></i> បញ្ជាក់ការបង់ប្រាក់
                            </button>
                            <a href="{{ route('loans.schedule', $loan) }}" class="btn btn-outline-secondary btn-lg">
                                <i class="bi bi-x-circle me-1"></i> បោះបង់
                            </a>
                        </div>

                    </form>
                @else
                    <div class="text-center py-4">
                        <a href="{{ route('loans.schedule', $loan) }}" class="btn btn-outline-primary">
                            <i class="bi bi-calendar3 me-1"></i> មើលកាលវិភាគ
                        </a>
                    </div>
                @endif

            </div>
        </div>
    </div>

</div>

@endsection
