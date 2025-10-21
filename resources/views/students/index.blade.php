<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            Students List
        </h2>
    </x-slot>

    <div class="py-6 px-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg text-gray-100">All Students</h3>
            <a href="{{ route('students.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                + Add Student
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-gray-800 text-white rounded-lg">
                <thead>
                    <tr class="bg-gray-700 text-gray-300">
                        <th class="px-4 py-2 text-left">#</th>
                        <th class="px-4 py-2 text-left">Name</th>
                        <th class="px-4 py-2 text-left">Roll Number</th>
                        <th class="px-4 py-2 text-left">Class</th>
                        <th class="px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr class="border-t border-gray-700">
                            <td class="px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2">{{ $student->name }}</td>
                            <td class="px-4 py-2">{{ $student->roll_number }}</td>
                            <td class="px-4 py-2">{{ $student->classroom->name ?? '-' }}</td>
                            <td class="px-4 py-2 flex gap-2">
                                <a href="{{ route('students.show', $student) }}" class="text-green-400 hover:underline">View</a>
                                <a href="{{ route('students.edit', $student) }}" class="text-blue-400 hover:underline">Edit</a>
                                <form action="{{ route('students.destroy', $student) }}" method="POST" onsubmit="return confirm('Are you sure?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-400 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
