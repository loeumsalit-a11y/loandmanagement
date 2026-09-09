@extends('Layout.app')
@section('title', 'ផ្ទាំងគ្រប់គ្រង — ហួសកំណត់បង់ប្រាក់')
@section('main')

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">
            <i class="bi bi-exclamation-triangle-fill me-2 text-danger"></i>
            អតិថិជនហួសកំណត់បង់ប្រាក់ (Overdue)
        </h3>
        <span class="badge bg-danger fs-6">{{ $overdueSchedules->total() }} ករណី</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-bordered mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>អតិថិជន</th>
                        <th>អ៊ីម៉ែល</th>
                        <th class="text-center">លើកទី</th>
                        <th>ថ្ងៃកំណត់បង់</th>
                        <th class="text-end">ប្រាក់ដើម ($)</th>
                        <th class="text-end">ការប្រាក់ ($)</th>
                        <th class="text-end">សរុប ($)</th>
                        <th class="text-center">សកម្មភាព</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($overdueSchedules as $schedule)
                        <tr class="table-danger">
                            <td>{{ $overdueSchedules->firstItem() + $loop->index }}</td>
                            <td><strong>{{ $schedule->loan->customer->name }}</strong></td>
                            <td>{{ $schedule->loan->customer->email }}</td>
                            <td class="text-center">{{ $schedule->installment_no }}</td>
                            <td>
                                {{ $schedule->due_date->format('d/m/Y') }}
                                <span class="badge bg-danger ms-1">
                                    {{ now()->diffInDays($schedule->due_date) }} ថ្ងៃហួស
                                </span>
                            </td>
                            <td class="text-end">{{ number_format($schedule->principal_due, 2) }}</td>
                            <td class="text-end">{{ number_format($schedule->interest_due, 2) }}</td>
                            <td class="text-end fw-bold">{{ number_format($schedule->total_due, 2) }}</td>
                            <td class="text-center">
                                <a href="{{ route('loans.schedule', $schedule->loan) }}" class="btn btn-sm btn-outline-dark">
                                    <i class="bi bi-eye"></i> មើល
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                <i class="bi bi-check-circle-fill text-success fs-3 d-block mb-2"></i>
                                គ្មានអតិថិជនហួសកំណត់បង់ប្រាក់!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if ($overdueSchedules->hasPages())
        <div class="card-footer">
            {{ $overdueSchedules->links() }}
        </div>
    @endif
</div>

@endsection
