@extends('Layout.app')

@section('title', 'Categories')
@section('main')
<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>គ្រប់គ្រងប្រភេទកម្ចី (Categories)</title>
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
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
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
        .badge-primary {
            background-color: #dbeafe;
            color: #1e40af;
        }

        /* Alerts */
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
            <h1 class="page-title">គ្រប់គ្រងប្រភេទកម្ចី (Categories)</h1>
            <p class="page-subtitle">បញ្ជីប្រភេទកម្ចី និងការផ្ដើរផ្ដើមព័ត៌មាន (Category Management)</p>
        </div>
        <a href="{{ route('categories.create') }}" class="btn btn-primary">
            + បន្ថែមប្រភេទកម្ចីថ្មី
        </a>
    </div>

    <!-- Success Flash Message -->
    @if (session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-title">សរុបប្រភេទកម្ចី (Total Categories)</div>
            <div class="stat-value">{{ $categories->count() }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-title">មានការពិពណ៌នា (With Description)</div>
            <div class="stat-value">{{ $categories->filter(fn($c) => !empty($c->description))->count() }}</div>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="filter-card">
        <div class="filter-form">
            <div class="form-group">
                <label for="categorySearch">ស្វែងរកប្រភេទកម្ចី (Search Category)</label>
                <input type="text" id="categorySearch" class="form-control" placeholder="វាយបញ្ចូលឈ្មោះប្រភេទកម្ចី...">
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="table-card">
        <div class="table-responsive">
            <table id="categoriesTable">
                <thead>
                    <tr>
                        <th style="width: 60px;">#</th>
                        <th>ឈ្មោះប្រភេទកម្ចី (Category Name)</th>
                        <th>ការពិពណ៌នា (Description)</th>
                        <th>កាលបរិច្ឆេទបង្កើត (Created At)</th>
                        <th style="width: 200px;">សកម្មភាព (Actions)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr>
                            <td><strong>{{ $loop->iteration }}</strong></td>
                            <td>
                                <span class="badge badge-primary">{{ $category->name }}</span>
                            </td>
                            <td>
                                @if ($category->description)
                                    <span>{{ $category->description }}</span>
                                @else
                                    <span style="color: #94a3b8; font-style: italic;">គ្មានការពិពណ៌នា</span>
                                @endif
                            </td>
                            <td>{{ $category->created_at ? $category->created_at->format('d-M-Y') : 'N/A' }}</td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('categories.show', $category->id) }}" class="btn btn-sm btn-info">មើល</a>
                                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-warning">កែប្រែ</a>
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('តើអ្នកពិតជាចង់លុបប្រភេទកម្ចីនេះមែនទេ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">លុប</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 40px; color: #64748b;">
                                មិនទាន់មានប្រភេទកម្ចីនៅឡើយទេ។ <a href="{{ route('categories.create') }}" style="color: #2563eb;">បន្ថែមថ្មី</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.getElementById('categorySearch')?.addEventListener('keyup', function() {
        const value = this.value.toLowerCase();
        const rows = document.querySelectorAll('#categoriesTable tbody tr');
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(value) ? '' : 'none';
        });
    });
</script>
</body>
</html>
@endsection


