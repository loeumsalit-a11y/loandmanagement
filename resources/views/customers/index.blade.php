@extends('Layout.app')

@section('title', 'Customers')
@section('main')
<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>បញ្ជីអតិថិជន (Customers)</title>
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
            max-width: 1280px;
            margin: 0 auto;
        }
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }
        .page-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #0f172a;
        }
        .page-subtitle {
            font-size: 0.875rem;
            color: #64748b;
            margin-top: 4px;
        }
        /* Dashboard Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }
        .stat-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        .stat-title {
            font-size: 0.875rem;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #0f172a;
            margin-top: 8px;
        }
        .city-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-top: 10px;
        }
        .city-chip {
            background: #f1f5f9;
            color: #334155;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 9999px;
            border: 1px solid #cbd5e1;
        }

        /* Buttons & Badges */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: all 0.2s ease;
            font-family: inherit;
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
        .btn-info {
            background-color: #0284c7;
            color: #ffffff;
        }
        .btn-info:hover {
            background-color: #0369a1;
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
        .btn-sm {
            padding: 4px 10px;
            font-size: 0.8rem;
            border-radius: 6px;
        }

        /* Filter Section */
        .filter-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 18px;
            margin-bottom: 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .filter-form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 12px;
            align-items: end;
        }
        .form-group label {
            display: block;
            font-size: 0.8125rem;
            font-weight: 600;
            color: #475569;
            margin-bottom: 6px;
        }
        .form-control {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
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

        /* Table */
        .table-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }
        th {
            background-color: #f8fafc;
            color: #475569;
            font-size: 0.8125rem;
            font-weight: 700;
            text-transform: uppercase;
            padding: 12px 16px;
            border-bottom: 1px solid #e2e8f0;
            white-space: nowrap;
        }
        td {
            padding: 14px 16px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.875rem;
            color: #334155;
            vertical-align: middle;
        }
        tr:hover td {
            background-color: #f8fafc;
        }
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 9999px;
            font-size: 0.75rem;
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

        /* Alerts & Pagination */
        .alert-success {
            background-color: #dcfce7;
            color: #15803d;
            border: 1px solid #bbf7d0;
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 20px;
            font-size: 0.875rem;
            font-weight: 500;
        }
        .pagination-wrapper {
            padding: 16px;
            border-top: 1px solid #e2e8f0;
            background: #ffffff;
        }
        .pagination-wrapper svg, .pagination svg, svg.w-5, svg.h-5 {
            width: 1.25rem;
            height: 1.25rem;
        }
        .code-tag {
            font-family: monospace;
            background: #f1f5f9;
            padding: 2px 6px;
            border-radius: 4px;
            color: #0f172a;
            font-weight: 600;
        }
        .action-buttons {
            display: flex;
            gap: 6px;
            align-items: center;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">ប្រព័ន្ធគ្រប់គ្រងព័ត៌មានអតិថិជន (Customers)</h1>
            <p class="page-subtitle">Laravel Eloquent ORM & CustomerController Exercise</p>
        </div>
        <a href="{{ route('customers.create') }}" class="btn btn-primary">
            + បន្ថែមអតិថិជនថ្មី
        </a>
    </div>

    <!-- Success Flash Message -->
    @if (session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Aggregate Functions Stats (ផ្នែកទី៥) -->
    <div class="stats-grid">
        <!-- 18. Count total customers -->
        <div class="stat-card">
            <div class="stat-title">ចំនួនអតិថិជនសរុប (Total Customers)</div>
            <div class="stat-value">{{ number_format($totalCustomers) }} នាក់</div>
        </div>

        <!-- 19. Count active status customers -->
        <div class="stat-card">
            <div class="stat-title">អតិថិជនសកម្ម (Active Status)</div>
            <div class="stat-value" style="color: #16a34a;">{{ number_format($totalActiveCustomers) }} នាក់</div>
        </div>

        <!-- 20. Count customers per city -->
        <div class="stat-card">
            <div class="stat-title">ចំនួនតាមខេត្ត/ក្រុង (By City)</div>
            <div class="city-chips">
                @forelse ($customersByCity as $cityStat)
                    <span class="city-chip">{{ $cityStat->city }}: {{ $cityStat->total }}</span>
                @empty
                    <span style="font-size:0.8rem; color:#94a3b8">គ្មានទិន្នន័យ</span>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Search & Filters Form (ផ្នែកទី៤) -->
    <div class="filter-card">
        <form method="GET" action="{{ route('customers.index') }}" class="filter-form">
            <!-- 12. Search by first_name or last_name -->
            <div class="form-group">
                <label for="name">ស្វែងរកតាមឈ្មោះ</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="ឈ្មោះ ឬ នាមត្រកូល..." value="{{ request('name') }}">
            </div>

            <!-- 13. Search by Phone Number -->
            <div class="form-group">
                <label for="phone">ស្វែងរកតាមលេខទូរស័ព្ទ</label>
                <input type="text" id="phone" name="phone" class="form-control" placeholder="លេខទូរស័ព្ទ..." value="{{ request('phone') }}">
            </div>

            <!-- 11. Filter by Status = Active -->
            <div class="form-group">
                <label for="status">ស្ថានភាព (Status)</label>
                <select id="status" name="status" class="form-control">
                    <option value="">-- ទាំងអស់ --</option>
                    <option value="Active" {{ request('status') === 'Active' ? 'selected' : '' }}>Active (សកម្ម)</option>
                    <option value="Inactive" {{ request('status') === 'Inactive' ? 'selected' : '' }}>Inactive (អសកម្ម)</option>
                </select>
            </div>

            <!-- 14. Filter by City -->
            <div class="form-group">
                <label for="city">ខេត្ត/ក្រុង (City)</label>
                <select id="city" name="city" class="form-control">
                    <option value="">-- គ្រប់ខេត្ត/ក្រុង --</option>
                    @foreach ($citiesList as $cityName)
                        <option value="{{ $cityName }}" {{ request('city') === $cityName ? 'selected' : '' }}>{{ $cityName }}</option>
                    @endforeach
                </select>
            </div>

            <!-- 15 & 16. Sorting -->
            <div class="form-group">
                <label for="sort">តម្រៀបទិន្នន័យ (Sort)</label>
                <select id="sort" name="sort" class="form-control">
                    <option value="latest" {{ request('sort', 'latest') === 'latest' ? 'selected' : '' }}>ថ្ងៃបង្កើតថ្មីបំផុត (Newest)</option>
                    <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>ថ្ងៃបង្កើតចាស់បំផុត (Oldest)</option>
                    <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>ឈ្មោះ (A-Z)</option>
                    <option value="name_desc" {{ request('sort') === 'name_desc' ? 'selected' : '' }}>ឈ្មោះ (Z-A)</option>
                </select>
            </div>

            <!-- Submit and Reset -->
            <div class="form-group" style="display:flex; gap:8px;">
                <button type="submit" class="btn btn-primary" style="flex:1">ស្វែងរក</button>
                <a href="{{ route('customers.index') }}" class="btn btn-secondary">កំណត់ឡើងវិញ</a>
            </div>
        </form>
    </div>

    <!-- Data Table (ផ្នែកទី២: CRUD Operations) -->
    <div class="table-card">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>កូដអតិថិជន</th>
                        <th>ឈ្មោះពេញ</th>
                        <th>ភេទ</th>
                        <th>លេខទូរស័ព្ទ</th>
                        <th>អ៊ីមែល</th>
                        <th>ខេត្ត/ក្រុង</th>
                        <th>ស្ថានភាព</th>
                        <th style="text-align: right;">សកម្មភាព</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($customers as $customer)
                        <tr>
                            <td>{{ $loop->iteration + ($customers->currentPage() - 1) * $customers->perPage() }}</td>
                            <td><span class="code-tag">{{ $customer->customer_code }}</span></td>
                            <td style="font-weight: 600; color: #0f172a;">{{ $customer->first_name }} {{ $customer->last_name }}</td>
                            <td>{{ $customer->gender == 'Male' ? 'ប្រុស' : 'ស្រី' }}</td>
                            <td>{{ $customer->phone }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->city ?? '-' }}</td>
                            <td>
                                @if ($customer->status === 'Active')
                                    <span class="badge badge-active">Active</span>
                                @else
                                    <span class="badge badge-inactive">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons" style="justify-content: flex-end;">
                                    <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-info btn-sm">មើល</a>
                                    <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning btn-sm">កែប្រែ</a>
                                    <form method="POST" action="{{ route('customers.destroy', $customer->id) }}" style="display:inline;" onsubmit="return confirm('តើអ្នកប្រាកដជាចង់លុបអតិថិជននេះមែនទេ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">លុប</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" style="text-align: center; color: #64748b; padding: 32px;">
                                មិនមានទិន្នន័យអតិថិជនឡើយ។
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- 17. Pagination (10 per page) -->
        <div class="pagination-wrapper">
            {{ $customers->links() }}
        </div>
    </div>
</div>


</body>
</html>

@endsection
