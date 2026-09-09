@extends('Layout.app')

@section('title', 'Edit Category')
@section('main')
<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>កែប្រែប្រភេទកម្ចី (Edit Category)</title>
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
        .error-message {
            color: #dc2626;
            font-size: 0.78rem;
            margin-top: 4px;
            font-weight: 500;
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
            transition: all 0.2s ease;
            font-family: inherit;
        }
        .btn-warning {
            background-color: #d97706;
            color: #ffffff;
        }
        .btn-warning:hover {
            background-color: #b45309;
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
            padding-top: 20px;
            border-top: 1px solid #f1f5f9;
            display: flex;
            gap: 12px;
            justify-content: flex-end;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card">
        <div class="card-header">
            <h1 class="card-title">កែប្រែប្រភេទកម្ចី #{{ $category->id }} (Edit Category)</h1>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                ← ត្រឡប់ក្រោយ
            </a>
        </div>

        <form action="{{ route('categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-grid">
                <div class="form-group full-width">
                    <label for="name">ឈ្មោះប្រភេទកម្ចី (Category Name) <span class="required">*</span></label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $category->name) }}" required>
                    @error('name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group full-width">
                    <label for="description">ការពិពណ៌នា (Description)</label>
                    <textarea name="description" id="description" rows="4" class="form-control">{{ old('description', $category->description) }}</textarea>
                    @error('description')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('categories.index') }}" class="btn btn-secondary">បោះបង់</a>
                <button type="submit" class="btn btn-warning">បច្ចុប្បន្នភាពប្រភេទកម្ចី</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
@endsection