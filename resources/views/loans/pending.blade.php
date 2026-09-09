@extends('Layout.app')
@section('title', 'ប្រាក់កម្ចីរង់ចាំការអនុម័ត')
@section('main')

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">
            <i class="bi bi-hourglass-split me-2 text-warning"></i>ប្រាក់កម្ចីរង់ចាំការអនុម័ត
        </h3>
        <span class="badge bg-warning text-dark fs-6">{{ $loans->total() }} ករណី</span>
    </div>
    <div class="card-body p-0">

        @if (session('success'))
            <div class="alert alert-success m-3">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger m-3">{{ session('error') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover table-striped mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>អតិថិជន</th>
                        <th>ប្រាក់ដើម ($)</th>
                        <th>អត្រា (%/ខែ)</th>
                        <th>រយៈពេល</th>
                        <th>ថ្ងៃដាក់ពាក្យ</th>
                        <th class="text-center">សកម្មភាព</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($loans as $loan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <strong>{{ $loan->customer->name }}</strong>
                                <br><small class="text-muted">{{ $loan->customer->email }}</small>
                            </td>
                            <td>{{ number_format($loan->principal_amount, 2) }}</td>
                            <td>{{ $loan->interest_rate }}%</td>
                            <td>{{ $loan->term_months }} ខែ</td>
                            <td>{{ $loan->created_at->format('d/m/Y') }}</td>
                            <td class="text-center">
                                <form action="{{ route('loans.approve', $loan) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('តើអ្នកចង់អនុម័តប្រាក់កម្ចីនេះដែរទេ?')">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="bi bi-check-circle me-1"></i> អនុម័ត
                                    </button>
                                </form>
                                <a href="{{ route('loans.show', $loan) }}" class="btn btn-info btn-sm ms-1">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                គ្មានប្រាក់កម្ចីរង់ចាំការអនុម័ត
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if ($loans->hasPages())
        <div class="card-footer">
            {{ $loans->links() }}
        </div>
    @endif
</div>

@endsection
