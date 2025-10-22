<x-app-layout><x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200">Leave Request Details</h2>
    </x-slot>
    <div class="py-6 px-6">
        <div class="bg-gray-800 p-6 rounded-lg text-gray-100 space-y-2">
            {{-- Standardized variable from $leaf to $leave --}}
            <p><strong>Student:</strong> {{ $leaf->student->name ?? 'N/A' }}</p>
            <p><strong>From:</strong> {{ \Carbon\Carbon::parse($leaf->from_date)->format('M d, Y') }}</p>
            <p><strong>To:</strong> {{ \Carbon\Carbon::parse($leaf->to_date)->format('M d, Y') }}</p>
            <p><strong>Type:</strong> {{ ucfirst($leaf->reason_type) }}</p>
            <p><strong>Reason:</strong> {{ $leaf->reason }}</p>
            <p><strong>Status:</strong>
                @if ($leaf->status == 'approved')
                    <span class="text-green-400 font-semibold">Approved</span>
                @elseif($leaf->status == 'rejected')
                    <span class="text-red-400 font-semibold">Rejected</span>
                @else
                    <span class="text-yellow-400 font-semibold">Pending</span>
                @endif
            </p>
        </div>

        {{-- Show action buttons only if status is pending AND user is authorized --}}
        @if ($leaf->status == 'pending' && (auth()->user()->role == 'admin' || auth()->user()->role == 'supervisor'))
            <div class="mt-4 flex gap-3">
                <form action="{{ route('leaves.approve', $leaf) }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 px-4 py-2 text-white rounded-md transition duration-150 ease-in-out">
                        Approve
                    </button>
                </form>

                <form action="{{ route('leaves.reject', $leaf) }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="bg-red-600 hover:bg-red-700 px-4 py-2 text-white rounded-md transition duration-150 ease-in-out">
                        Reject
                    </button>
                </form>
            </div>
        @elseif (auth()->user()->role == 'admin' || auth()->user()->role == 'supervisor')
            <p class="mt-4 text-sm text-gray-400">This request is already marked as <span
                    class="font-bold">{{ ucfirst($leaf->status) }}</span> and cannot be changed.</p>
        @endif


        <div class="mt-4">
            <a href="{{ route('leaves.index') }}" class="text-blue-400 hover:underline inline-flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to list
            </a>
        </div>
    </div>
</x-app-layout>
