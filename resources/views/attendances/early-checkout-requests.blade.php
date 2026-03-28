@extends('layouts.app')

@section('title', 'Early Checkout Requests')

@section('content')
<div class="bg-white rounded-lg shadow p-4 md:p-6">
    <h1 class="text-xl md:text-2xl font-bold mb-4 md:mb-6">Early Checkout Requests</h1>

    @if(session('success'))
    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
        {{ session('success') }}
    </div>
    @endif
    
    @if(session('error'))
    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
        {{ session('error') }}
    </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white text-sm md:text-base">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-2 md:px-4 py-2 text-left">Date</th>
                    <th class="px-2 md:px-4 py-2 text-left">User</th>
                    <th class="px-2 md:px-4 py-2 text-left hidden lg:table-cell">Shift</th>
                    <th class="px-2 md:px-4 py-2 text-left">Requested Time</th>
                    <th class="px-2 md:px-4 py-2 text-left hidden md:table-cell">Shift End</th>
                    <th class="px-2 md:px-4 py-2 text-left hidden lg:table-cell">Reason</th>
                    <th class="px-2 md:px-4 py-2 text-left">Status</th>
                    <th class="px-2 md:px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($requests as $request)
                <tr class="border-b">
                    <td class="px-2 md:px-4 py-2">{{ $request->attendance->date->format('d/m/Y') }}</td>
                    <td class="px-2 md:px-4 py-2">{{ $request->user->name }}</td>
                    <td class="px-2 md:px-4 py-2 hidden lg:table-cell">{{ $request->attendance->schedule->shift->name }}</td>
                    <td class="px-2 md:px-4 py-2 font-semibold text-red-600">{{ $request->requested_checkout_time }}</td>
                    <td class="px-2 md:px-4 py-2 hidden md:table-cell">{{ $request->shift_end_time }}</td>
                    <td class="px-2 md:px-4 py-2 hidden lg:table-cell">
                        <span class="text-sm text-gray-600">{{ $request->reason ?? '-' }}</span>
                    </td>
                    <td class="px-2 md:px-4 py-2">
                        @if($request->status === 'pending')
                        <span class="px-2 py-1 rounded text-xs md:text-sm bg-yellow-100 text-yellow-800">
                            Pending
                        </span>
                        @elseif($request->status === 'approved')
                        <span class="px-2 py-1 rounded text-xs md:text-sm bg-green-100 text-green-800">
                            Approved
                        </span>
                        @else
                        <span class="px-2 py-1 rounded text-xs md:text-sm bg-red-100 text-red-800">
                            Rejected
                        </span>
                        @endif
                    </td>
                    <td class="px-2 md:px-4 py-2">
                        @if($request->status === 'pending')
                        <div class="flex flex-col md:flex-row gap-2">
                            <button onclick="showApproveModal({{ $request->id }}, '{{ $request->user->name }}')" 
                                class="bg-green-500 text-white px-3 py-1 rounded text-xs md:text-sm hover:bg-green-600">
                                Approve
                            </button>
                            <button onclick="showRejectModal({{ $request->id }}, '{{ $request->user->name }}')" 
                                class="bg-red-500 text-white px-3 py-1 rounded text-xs md:text-sm hover:bg-red-600">
                                Reject
                            </button>
                        </div>
                        @else
                        <span class="text-xs text-gray-500">
                            By: {{ $request->approvedBy->name ?? '-' }}
                        </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-2 md:px-4 py-4 text-center text-gray-500">No early checkout requests</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $requests->links() }}
    </div>
</div>

<!-- Approve Modal -->
<div id="approveModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-lg p-6 max-w-md w-full">
        <h3 class="text-xl font-bold mb-4">Approve Early Checkout</h3>
        
        <p class="mb-4">Approve early checkout request for <span id="approveUserName" class="font-semibold"></span>?</p>

        <form method="POST" id="approveForm">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Admin Notes (optional):</label>
                <textarea name="admin_notes" rows="3" 
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                    placeholder="Add notes..."></textarea>
            </div>

            <div class="flex gap-3">
                <button type="submit" 
                    class="flex-1 bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                    Approve
                </button>
                <button type="button" onclick="closeApproveModal()" 
                    class="flex-1 bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-lg p-6 max-w-md w-full">
        <h3 class="text-xl font-bold mb-4">Reject Early Checkout</h3>
        
        <p class="mb-4">Reject early checkout request for <span id="rejectUserName" class="font-semibold"></span>?</p>

        <form method="POST" id="rejectForm">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Reason for rejection:</label>
                <textarea name="admin_notes" rows="3" required
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                    placeholder="Enter reason for rejection..."></textarea>
            </div>

            <div class="flex gap-3">
                <button type="submit" 
                    class="flex-1 bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
                    Reject
                </button>
                <button type="button" onclick="closeRejectModal()" 
                    class="flex-1 bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function showApproveModal(requestId, userName) {
    document.getElementById('approveUserName').textContent = userName;
    document.getElementById('approveForm').action = `/early-checkout/${requestId}/approve`;
    document.getElementById('approveModal').classList.remove('hidden');
    document.getElementById('approveModal').classList.add('flex');
}

function closeApproveModal() {
    document.getElementById('approveModal').classList.add('hidden');
    document.getElementById('approveModal').classList.remove('flex');
}

function showRejectModal(requestId, userName) {
    document.getElementById('rejectUserName').textContent = userName;
    document.getElementById('rejectForm').action = `/early-checkout/${requestId}/reject`;
    document.getElementById('rejectModal').classList.remove('hidden');
    document.getElementById('rejectModal').classList.add('flex');
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
    document.getElementById('rejectModal').classList.remove('flex');
}
</script>
@endsection
