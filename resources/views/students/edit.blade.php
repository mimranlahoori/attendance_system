<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200">Edit Student</h2>
    </x-slot>

    <div class="py-6 px-6">
        <form method="POST" action="{{ route('students.update', $student) }}" class="space-y-4 bg-gray-800 p-6 rounded-lg">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-gray-300">Name</label>
                <input type="text" name="name" value="{{ $student->name }}" class="w-full rounded-md bg-gray-700 text-white p-2" required>
            </div>

            <div>
                <label class="block text-gray-300">Roll Number</label>
                <input type="text" name="roll_number" value="{{ $student->roll_number }}" class="w-full rounded-md bg-gray-700 text-white p-2" required>
            </div>

            <div>
                <label class="block text-gray-300">Classroom</label>
                <select name="classroom_id" class="w-full rounded-md bg-gray-700 text-white p-2">
                    @foreach($classrooms as $classroom)
                        <option value="{{ $classroom->id }}" @if($classroom->id == $student->classroom_id) selected @endif>
                            {{ $classroom->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end">
                <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md">Update</button>
            </div>
        </form>
    </div>
</x-app-layout>
