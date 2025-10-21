<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200">New Leave Request</h2>
    </x-slot>

    <div class="py-6 px-6">
        <form method="POST" action="{{ route('leaves.store') }}"
              class="space-y-4 bg-gray-800 p-6 rounded-lg">
            @csrf

            <div>
                <label class="block text-gray-300">Student</label>
                <select name="student_id" class="w-full bg-gray-700 text-white rounded-md p-2" required>
                    <option value="">Select Student</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}">{{ $student->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-4">
                <div class="w-1/2">
                    <label class="block text-gray-300">From Date</label>
                    <input type="date" name="from_date" class="w-full bg-gray-700 text-white rounded-md p-2" required>
                </div>
                <div class="w-1/2">
                    <label class="block text-gray-300">To Date</label>
                    <input type="date" name="to_date" class="w-full bg-gray-700 text-white rounded-md p-2" required>
                </div>
            </div>

            <div>
                <label class="block text-gray-300">Reason Type</label>
                <select name="reason_type" class="w-full bg-gray-700 text-white rounded-md p-2">
                    <option value="sick">Sick</option>
                    <option value="personal">Personal</option>
                    <option value="emergency">Emergency</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <div>
                <label class="block text-gray-300">Detailed Reason</label>
                <textarea name="reason" rows="3" class="w-full bg-gray-700 text-white rounded-md p-2"></textarea>
            </div>

            <div class="flex justify-end">
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                    Submit Request
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
