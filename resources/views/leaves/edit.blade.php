<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200">Edit Leave Request</h2>
    </x-slot>

    <div class="py-6 px-6">
        <form method="POST" action="{{ route('leaves.update', $leaf) }}"
              class="space-y-4 bg-gray-800 p-6 rounded-lg">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-gray-300">Student</label>
                <select name="student_id" class="w-full bg-gray-700  rounded-md p-2" required>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}" @selected($student->id == $leaf->student_id)>
                            {{ $student->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-4">
                <div class="w-1/2">
                    <label class="block text-gray-300">From Date</label>
                    <input type="date" name="from_date" value="{{ $leaf->from_date }}" class="w-full bg-gray-700  rounded-md p-2">
                </div>
                <div class="w-1/2">
                    <label class="block text-gray-300">To Date</label>
                    <input type="date" name="to_date" value="{{ $leaf->to_date }}" class="w-full bg-gray-700  rounded-md p-2">
                </div>
            </div>

            <div>
                <label class="block text-gray-300">Reason Type</label>
                <select name="reason_type" class="w-full bg-gray-700  rounded-md p-2">
                    <option value="sick" @selected($leaf->reason_type == 'sick')>Sick</option>
                    <option value="personal" @selected($leaf->reason_type == 'personal')>Personal</option>
                    <option value="emergency" @selected($leaf->reason_type == 'emergency')>Emergency</option>
                    <option value="other" @selected($leaf->reason_type == 'other')>Other</option>
                </select>
            </div>

            <div>
                <label class="block text-gray-300">Detailed Reason</label>
                <textarea name="reason" rows="3" class="w-full bg-gray-700  rounded-md p-2">{{ $leaf->reason }}</textarea>
            </div>

            <div class="flex justify-end">
                <button class="bg-green-600 hover:bg-green-700  px-4 py-2 rounded-md">
                    Update
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
