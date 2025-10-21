<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200">Leave Request Details</h2>
    </x-slot>

    <div class="py-6 px-6">
        <div class="bg-gray-800 p-6 rounded-lg text-gray-100 space-y-2">
            <p><strong>Student:</strong> {{ $leave->student->name ?? '-' }}</p>
            <p><strong>From:</strong> {{ $leave->from_date }}</p>
            <p><strong>To:</strong> {{ $leave->to_date }}</p>
            <p><strong>Type:</strong> {{ ucfirst($leave->reason_type) }}</p>
            <p><strong>Reason:</strong> {{ $leave->reason }}</p>
            <p><strong>Status:</strong>
                @if($leave->status == 'approved')
                    <span class="text-green-400">Approved</span>
                @elseif($leave->status == 'rejected')
                    <span class="text-red-400">Rejected</span>
                @else
                    <span class="text-yellow-400">Pending</span>
                @endif
            </p>
        </div>

        @if (auth()->user()->role == 'admin' || auth()->user()->role == 'supervisor')
            <div class="mt-4 flex gap-3">
                <form action="{{ route('leaves.approve', $leave) }}" method="POST">
                    @csrf
                    <button class="bg-green-600 hover:bg-green-700 px-4 py-2 text-white rounded-md">
                        Approve
                    </button>
                </form>

                <form action="{{ route('leaves.reject', $leave) }}" method="POST">
                    @csrf
                    <button class="bg-red-600 hover:bg-red-700 px-4 py-2 text-white rounded-md">
                        Reject
                    </button>
                </form>
            </div>
        @endif

        <div class="mt-4">
            <a href="{{ route('leaves.index') }}" class="text-blue-400 hover:underline">← Back to list</a>
        </div>
    </div>
</x-app-layout>
