@extends('Layout.app')
@section('title', 'Create Customer')
@section('main')
<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>បន្ថែមអតិថិជនថ្មី (Create Customer)</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:ital,wght@0,300..700;1,300..700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Kantumruy Pro', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            padding: 24px;
            line-height: 1.5;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        .card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 32px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .card-header {
            margin-bottom: 24px;
            border-bottom: 1px solid #f1f5f9;
            padding-bottom: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .card-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #0f172a;
        }
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }
        .form-group {
            display: flex;
            flex-direction: column;
        }
        .form-group.full-width {
            grid-column: span 2;
        }
        label {
            font-size: 0.875rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 6px;
        }
        .required {
            color: #dc2626;
        }
        .form-control {
            padding: 10px 14px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 0.875rem;
            color: #1e293b;
            font-family: inherit;
            background-color: #ffffff;
        }
        .form-control:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }
        .is-invalid {
            border-color: #dc2626 !important;
        }
        .error-message {
            color: #dc2626;
            font-size: 0.8rem;
            margin-top: 4px;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            border: none;
            font-family: inherit;
            transition: background-color 0.2s;
        }
        .btn-primary {
            background-color: #2563eb;
            color: #ffffff;
        }
        .btn-primary:hover {
            background-color: #1d4ed8;
        }
        .btn-secondary {
            background-color: #64748b;
            color: #ffffff;
        }
        .btn-secondary:hover {
            background-color: #475569;
        }
        .form-actions {
            margin-top: 24px;
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card">
        <div class="card-header">
            <h1 class="card-title">បន្ថែមព័ត៌មានអតិថិជនថ្មី</h1>
            <a href="{{ route('customers.index') }}" class="btn btn-secondary">ត្រឡប់ក្រោយ</a>
        </div>

        <form method="POST" action="{{ route('customers.store') }}">
            @csrf

            <div class="form-grid">
                <!-- Customer Code -->
                <div class="form-group">
                    <label for="customer_code">កូដអតិថិជន (Customer Code) <span class="required">*</span></label>
                    <input type="text" id="customer_code" name="customer_code" class="form-control @error('customer_code') is-invalid @enderror" value="{{ old('customer_code') }}" placeholder="ឧ. CUST-10001" required>
                    @error('customer_code')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Status -->
                <div class="form-group">
                    <label for="status">ស្ថានភាព (Status) <span class="required">*</span></label>
                    <select id="status" name="status" class="form-control @error('status') is-invalid @enderror" required>
                        <option value="Active" {{ old('status', 'Active') === 'Active' ? 'selected' : '' }}>Active (សកម្ម)</option>
                        <option value="Inactive" {{ old('status') === 'Inactive' ? 'selected' : '' }}>Inactive (អសកម្ម)</option>
                    </select>
                    @error('status')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- First Name -->
                <div class="form-group">
                    <label for="first_name">នាមត្រកូល (First Name) <span class="required">*</span></label>
                    <input type="text" id="first_name" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}" placeholder="បញ្ចូលនាមត្រកូល" required>
                    @error('first_name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Last Name -->
                <div class="form-group">
                    <label for="last_name">នាមខ្លួន (Last Name) <span class="required">*</span></label>
                    <input type="text" id="last_name" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}" placeholder="បញ្ចូលនាមខ្លួន" required>
                    @error('last_name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Gender -->
                <div class="form-group">
                    <label for="gender">ភេទ (Gender) <span class="required">*</span></label>
                    <select id="gender" name="gender" class="form-control @error('gender') is-invalid @enderror" required>
                        <option value="">-- ជ្រើសរើស --</option>
                        <option value="Male" {{ old('gender') === 'Male' ? 'selected' : '' }}>ប្រុស (Male)</option>
                        <option value="Female" {{ old('gender') === 'Female' ? 'selected' : '' }}>ស្រី (Female)</option>
                    </select>
                    @error('gender')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Date of Birth -->
                <div class="form-group">
                    <label for="date_of_birth">ថ្ងៃខែឆ្នាំកំណើត (Date of Birth)</label>
                    <input type="date" id="date_of_birth" name="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror" value="{{ old('date_of_birth') }}">
                    @error('date_of_birth')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Phone -->
                <div class="form-group">
                    <label for="phone">លេខទូរស័ព្ទ (Phone) <span class="required">*</span></label>
                    <input type="text" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="012 345 678" required>
                    @error('phone')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email">អ៊ីមែល (Email) <span class="required">*</span></label>
                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="example@email.com" required>
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- City -->
                <div class="form-group full-width">
                    <label for="city">ខេត្ត/ក្រុង (City)</label>
                    <input type="text" id="city" name="city" class="form-control @error('city') is-invalid @enderror" value="{{ old('city') }}" placeholder="ឧ. Phnom Penh, Siem Reap...">
                    @error('city')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Address -->
                <div class="form-group full-width">
                    <label for="address">អាសយដ្ឋាន (Address)</label>
                    <textarea id="address" name="address" rows="3" class="form-control @error('address') is-invalid @enderror" placeholder="បញ្ចូលអាសយដ្ឋានលម្អិត...">{{ old('address') }}</textarea>
                    @error('address')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('customers.index') }}" class="btn btn-secondary">បោះបង់</a>
                <button type="submit" class="btn btn-primary">រក្សាទុក</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
@endsection