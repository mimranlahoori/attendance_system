<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200">Leave Requests</h2>
    </x-slot>

    <div class="py-6 px-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg text-gray-100">All Leave Requests</h3>
            <a href="{{ route('leaves.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
               + New Leave Request
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-gray-800 text-white rounded-lg">
                <thead>
                    <tr class="bg-gray-700 text-gray-300">
                        <th class="px-4 py-2 text-left">#</th>
                        <th class="px-4 py-2 text-left">Student</th>
                        <th class="px-4 py-2 text-left">From</th>
                        <th class="px-4 py-2 text-left">To</th>
                        <th class="px-4 py-2 text-left">Reason</th>
                        <th class="px-4 py-2 text-left">Status</th>
                        <th class="px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leaves as $leave)
                        <tr class="border-t border-gray-700">
                            <td class="px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2">{{ $leave->student->name ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $leave->from_date }}</td>
                            <td class="px-4 py-2">{{ $leave->to_date }}</td>
                            <td class="px-4 py-2">{{ ucfirst($leave->reason_type) }}</td>
                            <td class="px-4 py-2">
                                @if ($leave->status == 'approved')
                                    <span class="text-green-400 font-semibold">Approved</span>
                                @elseif ($leave->status == 'rejected')
                                    <span class="text-red-400 font-semibold">Rejected</span>
                                @else
                                    <span class="text-yellow-400 font-semibold">Pending</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 flex gap-2">
                                <a href="{{ route('leaves.show', $leave) }}" class="text-green-400 hover:underline">View</a>
                                <a href="{{ route('leaves.edit', $leave) }}" class="text-blue-400 hover:underline">Edit</a>
                                <form method="POST" action="{{ route('leaves.destroy', $leave) }}"
                                      onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-400 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-gray-400 py-4">No leave requests yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
