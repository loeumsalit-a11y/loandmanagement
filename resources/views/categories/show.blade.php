@extends('Layout.app')

@section('title', 'Category Details')
@section('main')

<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ព័ត៌មានលម្អិតប្រភេទកម្ចី (Category Detail)</title>
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
        .detail-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        .detail-item {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 14px 18px;
        }
        .detail-item.full-width {
            grid-column: span 2;
        }
        .detail-label {
            font-size: 0.78rem;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 4px;
        }
        .detail-value {
            font-size: 1rem;
            font-weight: 600;
            color: #0f172a;
        }
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .badge-primary {
            background-color: #dbeafe;
            color: #1e40af;
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
        .btn-danger {
            background-color: #dc2626;
            color: #ffffff;
        }
        .btn-danger:hover {
            background-color: #b91c1c;
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
            justify-content: space-between;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card">
        <div class="card-header">
            <h1 class="card-title">ព័ត៌មានលម្អិតប្រភេទកម្ចី #{{ $category->id }} (Category Detail)</h1>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                ← ត្រឡប់ក្រោយ
            </a>
        </div>

        <div class="detail-grid">
            <div class="detail-item">
                <div class="detail-label">លេខសម្គាល់ (Category ID)</div>
                <div class="detail-value">#{{ $category->id }}</div>
            </div>

            <div class="detail-item">
                <div class="detail-label">ឈ្មោះប្រភេទកម្ចី (Category Name)</div>
                <div class="detail-value">
                    <span class="badge badge-primary">{{ $category->name }}</span>
                </div>
            </div>

            <div class="detail-item full-width">
                <div class="detail-label">ការពិពណ៌នា (Description)</div>
                <div class="detail-value">
                    {{ $category->description ?? 'គ្មានការពិពណ៌នា' }}
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-label">កាលបរិច្ឆេទបង្កើត (Created At)</div>
                <div class="detail-value">{{ $category->created_at ? $category->created_at->format('d-M-Y H:i A') : 'N/A' }}</div>
            </div>

            <div class="detail-item">
                <div class="detail-label">កាលបរិច្ឆេទកែប្រែ (Updated At)</div>
                <div class="detail-value">{{ $category->updated_at ? $category->updated_at->format('d-M-Y H:i A') : 'N/A' }}</div>
            </div>
        </div>

        <div class="form-actions">
            <div>
                <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning">កែប្រែ</a>
                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('តើអ្នកពិតជាចង់លុបប្រភេទកម្ចីនេះមែនទេ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">លុប</button>
                </form>
            </div>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">ត្រឡប់ទៅបញ្ជី</a>
        </div>
    </div>
</div>

</body>
</html>
@endsection


