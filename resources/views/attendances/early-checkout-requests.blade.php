@extends('layouts.app')
@section('title', 'Early Checkout Requests')
@section('content')
<div class="gh-card">
    <div class="gh-card-header">
        <h1 class="font-header" style="letter-spacing:0.1em;">Early Checkout Requests</h1>
    </div>
    <div class="overflow-x-auto">
        <table class="gh-table">
            <thead><tr>
                <th>Date</th>
                <th>User</th>
                <th class="hidden lg:table-cell">Shift</th>
                <th>Requested Time</th>
                <th class="hidden md:table-cell">Shift End</th>
                <th class="hidden lg:table-cell">Reason</th>
                <th>Status</th>
                <th>Actions</th>
            </tr></thead>
            <tbody>
                @forelse($requests as $request)
                <tr>
                    <td style="color:var(--gray-500);">{{ $request->attendance->date->format('d/m/Y') }}</td>
                    <td class="font-bold" style="color:var(--brown-900);">{{ $request->user->name }}</td>
                    <td class="hidden lg:table-cell" style="color:var(--gray-500);">{{ $request->attendance->schedule->shift->name }}</td>
                    <td class="font-bold" style="color:#b91c1c;">{{ $request->requested_checkout_time }}</td>
                    <td class="hidden md:table-cell" style="color:var(--gray-500);">{{ $request->shift_end_time }}</td>
                    <td class="hidden lg:table-cell" style="color:var(--gray-500); font-size:0.8rem;">{{ $request->reason ?? '—' }}</td>
                    <td>
                        <span class="badge
                            @if($request->status === 'pending') badge-warning
                            @elseif($request->status === 'approved') badge-success
                            @else badge-danger @endif">
                            {{ ucfirst($request->status) }}
                        </span>
                    </td>
                    <td class="whitespace-nowrap">
                        @if($request->status === 'pending')
                        <div class="flex gap-2">
                            <button onclick="showApproveModal({{ $request->id }}, '{{ $request->user->name }}')"
                                class="btn btn-success text-xs px-3 py-1.5">Approve</button>
                            <button onclick="showRejectModal({{ $request->id }}, '{{ $request->user->name }}')"
                                class="btn btn-danger text-xs px-3 py-1.5" style="background:#dc2626; color:#fff;">Reject</button>
                        </div>
                        @else
                        <span class="text-xs" style="color:var(--gray-300);">{{ $request->approvedBy->name ?? '—' }}</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-10" style="color:var(--gray-300);">
                        <svg class="w-8 h-8 mx-auto mb-2 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        No early checkout requests
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4">{{ $requests->links() }}</div>
</div>

<!-- Approve Modal -->
<div id="approveModal" class="fixed inset-0 hidden items-center justify-center z-50 p-4" style="background:rgba(58,42,26,0.6);">
    <div class="gh-card w-full max-w-md">
        <div class="gh-card-header">
            <h3 class="font-header" style="letter-spacing:0.1em;">Approve Early Checkout</h3>
        </div>
        <div class="gh-card-body">
            <p class="mb-4 text-sm" style="color:var(--gray-500);">Approve request for <span id="approveUserName" class="font-bold" style="color:var(--brown-900);"></span>?</p>
            <form method="POST" id="approveForm">
                @csrf
                <div class="mb-5">
                    <label class="gh-label">Admin Notes (optional)</label>
                    <textarea name="admin_notes" rows="3" class="gh-textarea" placeholder="Add notes..."></textarea>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="btn btn-success flex-1 justify-center">Approve</button>
                    <button type="button" onclick="closeApproveModal()" class="btn btn-secondary flex-1 justify-center">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 hidden items-center justify-center z-50 p-4" style="background:rgba(58,42,26,0.6);">
    <div class="gh-card w-full max-w-md">
        <div class="gh-card-header">
            <h3 class="font-header" style="letter-spacing:0.1em;">Reject Early Checkout</h3>
        </div>
        <div class="gh-card-body">
            <p class="mb-4 text-sm" style="color:var(--gray-500);">Reject request for <span id="rejectUserName" class="font-bold" style="color:var(--brown-900);"></span>?</p>
            <form method="POST" id="rejectForm">
                @csrf
                <div class="mb-5">
                    <label class="gh-label">Reason for rejection</label>
                    <textarea name="admin_notes" rows="3" required class="gh-textarea" placeholder="Enter reason..."></textarea>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="btn btn-primary flex-1 justify-center">Reject</button>
                    <button type="button" onclick="closeRejectModal()" class="btn btn-secondary flex-1 justify-center">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showApproveModal(id, name) {
    document.getElementById('approveUserName').textContent = name;
    document.getElementById('approveForm').action = `/early-checkout/${id}/approve`;
    document.getElementById('approveModal').classList.remove('hidden');
    document.getElementById('approveModal').classList.add('flex');
}
function closeApproveModal() {
    document.getElementById('approveModal').classList.add('hidden');
    document.getElementById('approveModal').classList.remove('flex');
}
function showRejectModal(id, name) {
    document.getElementById('rejectUserName').textContent = name;
    document.getElementById('rejectForm').action = `/early-checkout/${id}/reject`;
    document.getElementById('rejectModal').classList.remove('hidden');
    document.getElementById('rejectModal').classList.add('flex');
}
function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
    document.getElementById('rejectModal').classList.remove('flex');
}
</script>
@endsection
