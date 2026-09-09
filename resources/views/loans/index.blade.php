@extends('Layout.app')
@section('title', 'ប្រាក់កម្ចីទាំងអស់')
@section('main')

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">
            <i class="bi bi-wallet-fill me-2 text-primary"></i>បញ្ជីប្រាក់កម្ចីទាំងអស់
        </h3>
        <span class="badge bg-primary text-white fs-6">{{ $loans->total() }} កម្ចី</span>
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
                        <th>ស្ថានភាព</th>
                        <th class="text-center">សកម្មភាព</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($loans as $loan)
                        <tr>
                            <td>{{ $loan->id }}</td>
                            <td>
                                <strong>{{ $loan->customer->name }}</strong>
                                <br><small class="text-muted">{{ $loan->customer->email }}</small>
                            </td>
                            <td>{{ number_format($loan->principal_amount, 2) }}</td>
                            <td>{{ $loan->interest_rate }}%</td>
                            <td>{{ $loan->term_months }} ខែ</td>
                            <td>
                                @php
                                    $badgeClass = match($loan->status) {
                                        'Pending'   => 'bg-secondary',
                                        'Approved'  => 'bg-info',
                                        'Disbursed' => 'bg-success',
                                        'Rejected'  => 'bg-danger',
                                        default     => 'bg-dark',
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ $loan->status }}</span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('loans.show', $loan) }}" class="btn btn-info btn-sm" title="លម្អិត">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    
                                    @if ($loan->status === 'Approved' && auth()->user()->isAdmin())
                                        <form action="{{ route('loans.disburse', $loan) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('តើអ្នកចង់បើកប្រាក់កម្ចីនេះមែនទេ?')">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm" title="បើកប្រាក់">
                                                <i class="bi bi-cash"></i>
                                            </button>
                                        </form>
                                    @endif

                                    @if ($loan->status === 'Disbursed')
                                        <a href="{{ route('loans.schedule', $loan) }}" class="btn btn-primary btn-sm" title="កាលវិភាគ">
                                            <i class="bi bi-calendar3"></i>
                                        </a>
                                        @can('repay', $loan)
                                            <a href="{{ route('loans.repay', $loan) }}" class="btn btn-warning btn-sm" title="កត់ការបង់ប្រាក់">
                                                <i class="bi bi-credit-card"></i>
                                            </a>
                                        @endcan
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                មិនទាន់មានប្រាក់កម្ចីណាមួយនៅឡើយទេ
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
