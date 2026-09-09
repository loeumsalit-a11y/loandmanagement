@extends('Layout.app')
@section('title', 'កត់ការបង់ប្រាក់')
@section('main')

<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card card-warning card-outline shadow-sm">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="bi bi-credit-card me-2"></i>កត់ការបង់ប្រាក់ — {{ $loan->customer->name }}
                </h3>
            </div>
            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Next installment summary --}}
                @if ($nextSchedule)
                    <div class="alert alert-info">
                        <strong>ការបង់ប្រាក់បន្ទាប់ (លើកទី {{ $nextSchedule->installment_no }}):</strong>
                        <ul class="mb-0 mt-1">
                            <li>ថ្ងៃបង់: <strong>{{ $nextSchedule->due_date->format('d/m/Y') }}</strong></li>
                            <li>ប្រាក់ដើម: <strong>${{ number_format($nextSchedule->principal_due, 2) }}</strong></li>
                            <li>ការប្រាក់: <strong>${{ number_format($nextSchedule->interest_due, 2) }}</strong></li>
                            <li>សរុបត្រូវបង់: <strong class="text-danger">${{ number_format($nextSchedule->total_due, 2) }}</strong></li>
                        </ul>
                    </div>
                @else
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle-fill me-2"></i>ប្រាក់កម្ចីនេះបានបង់ប្រាក់ទាំងស្រុងហើយ!
                    </div>
                @endif

                @if ($nextSchedule)
                    <form action="{{ route('loans.repay.store', $loan) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="amount_paid" class="form-label fw-semibold">ទឹកប្រាក់បង់ ($)</label>
                            <input type="number" step="0.01" min="0.01"
                                class="form-control @error('amount_paid') is-invalid @enderror"
                                id="amount_paid" name="amount_paid" value="{{ old('amount_paid') }}"
                                placeholder="ឧ. {{ number_format($nextSchedule->total_due, 2) }}" required>
                            <div class="form-text text-muted">
                                បង់លើសទៅ ${{ number_format($nextSchedule->total_due, 2) }} នឹងត្រូវផ្ទេរទៅការបង់ប្រាក់លើកបន្ទាប់ដោយស្វ័យប្រវត្តិ។
                            </div>
                            @error('amount_paid')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="payment_method" class="form-label fw-semibold">វិធីសាស្ត្របង់ប្រាក់</label>
                            <select class="form-select @error('payment_method') is-invalid @enderror"
                                id="payment_method" name="payment_method" required>
                                <option value="Cash" {{ old('payment_method') == 'Cash' ? 'selected' : '' }}>ក្រដាស​ (Cash)</option>
                                <option value="Transfer" {{ old('payment_method') == 'Transfer' ? 'selected' : '' }}>ផ្ទេរ (Transfer)</option>
                                <option value="ABA" {{ old('payment_method') == 'ABA' ? 'selected' : '' }}>ABA Bank</option>
                                <option value="Wing" {{ old('payment_method') == 'Wing' ? 'selected' : '' }}>Wing</option>
                            </select>
                            @error('payment_method')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-check-circle me-1"></i> កត់ការបង់ប្រាក់
                            </button>
                            <a href="{{ route('loans.schedule', $loan) }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> ត្រឡប់
                            </a>
                        </div>
                    </form>
                @else
                    <a href="{{ route('loans.schedule', $loan) }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i> ត្រឡប់ទៅកាលវិភាគ
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
