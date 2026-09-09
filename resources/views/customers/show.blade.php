
@extends('Layout.app')
@section('title', 'Customer Details')
@section('main')

<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ព័ត៌មានលម្អិតអតិថិជន (Customer Detail)</title>
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
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        .badge-active {
            background-color: #dcfce7;
            color: #15803d;
        }
        .badge-inactive {
            background-color: #fee2e2;
            color: #b91c1c;
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
        .btn-secondary {
            background-color: #64748b;
            color: #ffffff;
        }
        .btn-secondary:hover {
            background-color: #475569;
        }
        .btn-warning {
            background-color: #d97706;
            color: #ffffff;
        }
        .btn-warning:hover {
            background-color: #b45309;
        }
        .actions {
            margin-top: 24px;
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }
        .code-tag {
            font-family: monospace;
            background: #e2e8f0;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 1rem;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card">
        <div class="card-header">
            <h1 class="card-title">ព័ត៌មានលម្អិតអតិថិជន</h1>
            <a href="{{ route('customers.index') }}" class="btn btn-secondary">ត្រឡប់ក្រោយ</a>
        </div>

        <div class="detail-grid">
            <div class="detail-item">
                <div class="detail-label">កូដអតិថិជន (Customer Code)</div>
                <div class="detail-value"><span class="code-tag">{{ $customer->customer_code }}</span></div>
            </div>

            <div class="detail-item">
                <div class="detail-label">ស្ថានភាព (Status)</div>
                <div class="detail-value">
                    @if ($customer->status === 'Active')
                        <span class="badge badge-active">Active (សកម្ម)</span>
                    @else
                        <span class="badge badge-inactive">Inactive (អសកម្ម)</span>
                    @endif
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-label">ឈ្មោះពេញ (Full Name)</div>
                <div class="detail-value">{{ $customer->first_name }} {{ $customer->last_name }}</div>
            </div>

            <div class="detail-item">
                <div class="detail-label">ភេទ (Gender)</div>
                <div class="detail-value">{{ $customer->gender === 'Male' ? 'ប្រុស (Male)' : 'ស្រី (Female)' }}</div>
            </div>

            <div class="detail-item">
                <div class="detail-label">ថ្ងៃខែឆ្នាំកំណើត (Date of Birth)</div>
                <div class="detail-value">{{ optional($customer->date_of_birth)->format('d-M-Y') ?? 'មិនបានបញ្ចូល' }}</div>
            </div>

            <div class="detail-item">
                <div class="detail-label">លេខទូរស័ព្ទ (Phone Number)</div>
                <div class="detail-value">{{ $customer->phone }}</div>
            </div>

            <div class="detail-item">
                <div class="detail-label">អ៊ីមែល (Email Address)</div>
                <div class="detail-value">{{ $customer->email }}</div>
            </div>

            <div class="detail-item">
                <div class="detail-label">ខេត្ត/ក្រុង (City)</div>
                <div class="detail-value">{{ $customer->city ?? 'មិនបានបញ្ចូល' }}</div>
            </div>

            <div class="detail-item full-width">
                <div class="detail-label">អាសយដ្ឋាន (Address)</div>
                <div class="detail-value">{{ $customer->address ?? 'មិនបានបញ្ចូល' }}</div>
            </div>

            <div class="detail-item">
                <div class="detail-label">កាលបរិច្ឆេទបង្កើត (Created At)</div>
                <div class="detail-value">{{ $customer->created_at ? $customer->created_at->format('d-M-Y H:i') : '-' }}</div>
            </div>

            <div class="detail-item">
                <div class="detail-label">កាលបរិច្ឆេទកែប្រែចុងក្រោយ (Updated At)</div>
                <div class="detail-value">{{ $customer->updated_at ? $customer->updated_at->format('d-M-Y H:i') : '-' }}</div>
            </div>
        </div>

        <div class="actions">
            <a href="{{ route('customers.index') }}" class="btn btn-secondary">ត្រឡប់ទៅបញ្ជី</a>
            <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning">កែប្រែព័ត៌មាន</a>
        </div>
    </div>
</div>

</body>
</html>
@endsection
