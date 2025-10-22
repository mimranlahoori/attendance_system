<x-app-layout>
    <div class="container mx-auto p-4">
        <h2 class="text-3xl font-semibold text-gray-800 dark:text-white mb-4">Attendance for Class:
            {{ $classroom->name }} {{ $classroom->section ? '(' . $classroom->section . ')' : '' }}
        </h2>

        <form method="GET" action="{{ route('attendances.index', $classroom->id) }}" class="mb-6">
            <label for="month" class="block text-sm font-medium text-gray-800 dark:text-white mb-2">Select
                Month:</label>
            <input type="month" id="month" name="month" value="{{ $month }}" class="p-2 border border-gray-300 rounded"
                onchange="this.form.submit()">
            <button type="submit" class="ml-2 bg-blue-500 text-white px-4 py-2 rounded">Filter</button>
            <a href="{{ route('holidays.index') }}"
                class="bg-orange-600 text-white py-2 px-4 rounded shadow-md hover:bg-orange-700 transition duration-300 mb-4 inline-block">Holidays</a>
            <a href="{{ route('class.attendances.classAttendanceSheet', $classroom->id) }}"
                class="bg-green-600 text-white py-2 px-4 rounded shadow-md hover:bg-green-700 transition duration-300 mb-4 inline-block">Attendance Sheet</a>

        </form>

        <div class="overflow-auto">
            <table class="min-w-full border border-gray-700 rounded-lg overflow-hidden">
                <thead class="bg-gray-800">
                    <tr>
                        <th class="px-4 py-2 border border-gray-700 text-left">Student Name</th>
                        <th class="px-4 py-2 border border-gray-700 text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($classroom->students as $student)
                        @php
                            $today = now()->format('Y-m-d');
                            $attendance = $student->attendances->where('date', $today)->first();
                        @endphp
                        <tr class="hover:bg-gray-800 transition">
                            <td class="px-4 py-2 border border-gray-700">{{ $student->name }}</td>
                            <td class="px-4 py-2 border border-gray-700 text-center">
                                @if (!$attendance)
                                    <button onclick="openModal('{{ $student->id }}', '{{ $student->name }}')"
                                        class="text-green-400 hover:text-green-600 transition">
                                        Mark Attendance
                                    </button>
                                @else
                                    <span class="text-gray-400 italic">Attendance Marked</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div id="attendanceModal" class="hidden fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50">
        <div class="bg-gray-800 p-6 rounded-lg w-96 shadow-xl">
            <h3 class="text-lg font-semibold mb-4">Mark Attendance for <span id="studentName"></span></h3>

            <form action="{{ route('classrooms.attendances.store', $classroom->id) }}" method="POST"
                id="attendanceForm">
                @csrf
                <input type="hidden" name="student_id" id="studentId">
                <input type="hidden" name="date" value="{{ now()->format('Y-m-d') }}">

                <label class="block text-sm mb-2">Status:</label>
                <select name="status" class="w-full bg-gray-700 text-white p-2 rounded mb-4">
                    <option value="present">Present</option>
                    <option value="absent">Absent</option>
                    <option value="late">Late</option>
                    <option value="leave">Leave</option>
                    <option value="holiday">Holiday</option>
                </select>

                <label class="block text-sm mb-2">Remarks (optional):</label>
                <textarea name="remarks" class="w-full bg-gray-700 text-white p-2 rounded mb-4"
                    placeholder="Add any notes..."></textarea>

                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeModal()"
                        class="bg-gray-600 hover:bg-gray-700 px-4 py-1 rounded">Cancel</button>
                    <button type="submit" class="bg-green-600 hover:bg-green-700 px-4 py-1 rounded">Save</button>
                </div>
            </form>

        </div>
    </div>

    <script>
        function openModal(id, name) {
            document.getElementById('studentId').value = id;
            document.getElementById('studentName').innerText = name;
            document.getElementById('attendanceModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('attendanceModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
