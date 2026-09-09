@extends('Layout.app')
@section('title', 'កំណត់ប្រាក់កម្ចី')
@section('main')

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card card-warning card-outline shadow-sm">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="bi bi-sliders me-2"></i>កំណត់អត្រាការប្រាក់
                </h3>
            </div>
            <div class="card-body">

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-1"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <p class="text-muted mb-4">
                    <i class="bi bi-info-circle me-1"></i>
                    តម្លៃដែលកំណត់នៅទីនេះ នឹងត្រូវបានអនុវត្តដោយស្វ័យប្រវត្តិ
                    ចំពោះការស្នើសុំប្រាក់កម្ចីថ្មីទាំងអស់ក្នុងអនាគត។
                </p>

                <form action="{{ route('loans.settings.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="default_interest_rate" class="form-label fw-semibold fs-6">
                            {{ $settings['default_interest_rate']->label ?? 'អត្រាការប្រាក់លំនាំដើម (% / ខែ)' }}
                        </label>
                        <div class="input-group">
                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                max="100"
                                id="default_interest_rate"
                                name="default_interest_rate"
                                class="form-control form-control-lg @error('default_interest_rate') is-invalid @enderror"
                                value="{{ old('default_interest_rate', $settings['default_interest_rate']->value ?? 2.00) }}"
                                required>
                            <span class="input-group-text">% / ខែ</span>
                            @error('default_interest_rate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-text">ឧ. 2.00 = 2% ក្នុងមួយខែ</div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-save me-1"></i> រក្សាទុក
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
