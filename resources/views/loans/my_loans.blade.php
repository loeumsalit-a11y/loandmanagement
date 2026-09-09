@extends('Layout.app')
@section('title', 'ប្រាក់កម្ចីរបស់ខ្ញុំ')
@section('main')

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">
            <i class="bi bi-wallet2 me-2 text-primary"></i>ប្រាក់កម្ចីរបស់ខ្ញុំ
        </h3>
        <a href="{{ route('loans.apply') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-file-earmark-plus me-1"></i> ស្នើសុំកម្ចីថ្មី
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>កាលបរិច្ឆេទស្នើ</th>
                        <th>ប្រាក់ដើម ($)</th>
                        <th>អត្រា (%/ខែ)</th>
                        <th>រយៈពេល (ខែ)</th>
                        <th>ស្ថានភាព</th>
                        <th class="text-center">សកម្មភាព</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($loans as $loan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $loan->created_at->format('d/m/Y') }}</td>
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
                                @if ($loan->status === 'Disbursed')
                                    <a href="{{ route('loans.schedule', $loan) }}" class="btn btn-info btn-sm">
                                        <i class="bi bi-calendar3 me-1"></i> កាលវិភាគ
                                    </a>
                                @endif
                                <a href="{{ route('loans.show', $loan) }}" class="btn btn-secondary btn-sm ms-1">
                                    <i class="bi bi-eye"></i> លម្អិត
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                លោកអ្នកមិនទាន់មានប្រាក់កម្ចីនៅឡើយទេ។
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
