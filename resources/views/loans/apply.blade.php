@extends('Layout.app')
@section('title', 'ស្នើសុំប្រាក់កម្ចី')
@section('main')

<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card card-primary card-outline shadow-sm">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="bi bi-cash-coin me-2"></i>ស្នើសុំប្រាក់កម្ចី
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

                <form action="{{ route('loans.apply.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="principal_amount" class="form-label fw-semibold">
                            ទឹកប្រាក់ដើម ($)
                        </label>
                        <input type="number" step="0.01" min="1" class="form-control @error('principal_amount') is-invalid @enderror"
                            id="principal_amount" name="principal_amount" value="{{ old('principal_amount') }}"
                            placeholder="ឧ. 1000.00" required>
                        @error('principal_amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            អត្រាការប្រាក់ប្រចាំខែ (%)
                        </label>
                        <div class="form-control bg-light d-flex align-items-center gap-2" style="cursor: not-allowed;">
                            <i class="bi bi-lock-fill text-secondary"></i>
                            <span>{{ $defaultInterestRate }}% <small class="text-muted">(កំណត់ដោយអ្នកគ្រប់គ្រង)</small></span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="term_months" class="form-label fw-semibold">
                            រយៈពេល (ខែ)
                        </label>
                        <input type="number" min="1" max="360" class="form-control @error('term_months') is-invalid @enderror"
                            id="term_months" name="term_months" value="{{ old('term_months') }}"
                            placeholder="ឧ. 12" required>
                        @error('term_months')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send me-1"></i> ដាក់ពាក្យ
                        </button>
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-1"></i> បោះបង់
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
