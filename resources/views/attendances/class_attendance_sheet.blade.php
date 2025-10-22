<x-app-layout>

    <div class="container mx-auto p-4">
        <h2 class="text-3xl font-semibold text-gray-800 dark:text-white mb-4">Attendance for Class:
            {{ $classroom->name }}
            {{ $classroom->section ? '(' . $classroom->section . ')' : '' }}</h2>
        <div class="flex justify-between items-center">
            <form method="GET" action="{{ route('class.attendances.classAttendanceSheet', $classroom->id) }}"
                class="text-black mb-6">
                <label for="month" class="block text-sm font-medium text-gray-800 dark:text-white mb-2">Select
                    Month:</label>
                <input type="month" id="month" name="month" value="{{ $month }}"
                    class="p-2 border border-gray-300 rounded" onchange="this.form.submit()">
                <button type="submit" class="ml-2 bg-blue-500 text-white px-4 py-2 rounded">Filter</button>
            </form>
            <a href="/"
                class="bg-red-600 text-white py-2 px-4 rounded shadow-md hover:bg-red-700 transition duration-300 mb-4 inline-block">Print
                PDF</a>
        </div>



        <div class="overflow-auto">
            <table class="min-w-full table-auto border-collapse border border-gray-500">
                <thead>
                    <tr class="bg-gray-800 text-white">
                        <th class="border border-gray-600 text-gray-800 dark:text-white px-4 py-2">Name</th>
                        @php
                            $total_working_days = 0; // To track total non-holiday days for accurate Total Absents calculation later if needed
                        @endphp
                        @for ($day = 1; $day <= \Carbon\Carbon::parse($month)->daysInMonth; $day++)
                            @php
                                $date = $month . '-' . str_pad($day, 2, '0', STR_PAD_LEFT);
                                $dayName = \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format('D'); // Short day name (e.g., Mon)
                                $isHoliday = \App\Models\Holiday::where('date', $date)
                                    ->where('is_holiday', true)
                                    ->exists();
                            @endphp
                            @if (!$isHoliday)
                                @php $total_working_days++; @endphp
                                <th class="border border-gray-600 text-gray-800 dark:text-white px-2 py-1 text-center">
                                    {{ $day }}<br><span class="text-xs">{{ $dayName }}</span>
                                </th>
                            @endif
                        @endfor
                        <th class="border border-gray-600 text-gray-800 dark:text-white px-4 py-2">Total Present</th>
                        <th class="border border-gray-600 text-gray-800 dark:text-white px-4 py-2">Total Absents</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($classroom->students as $student)
                        <tr>
                            <td class=" min-w-52  border border-gray-600 text-gray-800 dark:text-white px-4 py-2">
                                {{ $student->name }}
                            </td>
                            @php
                                $presentCount = 0;
                                $attendanceRecords = $student->attendances
                                    ->whereBetween('date', [
                                        $month . '-01',
                                        $month . '-' . \Carbon\Carbon::parse($month)->daysInMonth,
                                    ])
                                    ->keyBy('date');
                            @endphp
                            @for ($day = 1; $day <= \Carbon\Carbon::parse($month)->daysInMonth; $day++)
                                @php
                                    $date = $month . '-' . str_pad($day, 2, '0', STR_PAD_LEFT);
                                    $attendance = $attendanceRecords->get($date);

                                    // Re-check for holiday for the table cells to ensure consistency with the header
                                    $isHoliday = \App\Models\Holiday::where('date', $date)
                                        ->where('is_holiday', true)
                                        ->exists();
                                @endphp
                                @if (!$isHoliday)
                                    <td class="border border-gray-600 text-center text-sm">
                                        @if ($attendance)
                                            @switch($attendance->status)
                                                @case('present')
                                                    <span class="text-green-500 font-bold">P</span>
                                                    @php $presentCount++; @endphp
                                                @break

                                                @case('absent')
                                                    <span class="text-red-500 font-bold">A</span>
                                                @break

                                                @case('late')
                                                    <span class="text-orange-500 font-bold">L</span>
                                                    {{-- Depending on your business logic, you might want to count 'late' as 'present' --}}
                                                    {{-- @php $presentCount++; @endphp --}}
                                                @break

                                                @case('leave')
                                                    <span class="text-blue-500 font-bold">Lv</span>
                                                @break

                                                @default
                                                    <span class="text-gray-400">-</span>
                                            @endswitch
                                        @else
                                            {{-- No attendance record for a non-holiday working day --}}
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                @endif
                            @endfor
                            <td class="border border-gray-600 text-gray-800 dark:text-white text-center font-bold">
                                {{ $presentCount }}</td>
                            @php
                                // Filter attendance records to count 'absent' only for the current month
                                $absentCount = $attendanceRecords->where('status', 'absent')->count();

                                // You might need a more complex calculation if 'absent' includes days without an explicit record
                                // If you want to count days with no record as absent:
                                // $attendedDays = $attendanceRecords->count();
                                // $absentCount = $total_working_days - $attendedDays;
                                // But the current 'where' filter is safer if all statuses are recorded.

                            @endphp

                            <td class="border border-gray-600 text-gray-800 dark:text-white text-center font-bold">
                                {{ $absentCount }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4 text-sm text-gray-700 dark:text-gray-300">
                <strong>Legend:</strong>
                <span class="text-green-500 font-bold">P</span> = Present,
                <span class="text-red-500 font-bold">A</span> = Absent,
                <span class="text-orange-500 font-bold">L</span> = Late,
                <span class="text-blue-500 font-bold">Lv</span> = Leave,
                <span class="text-yellow-500 font-bold">H</span> = Holiday
            </div>

        </div>
    </div>
</x-app-layout>
