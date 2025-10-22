<x-app-layout>
    <div class="max-w-7xl mx-auto py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-100">📚 Classrooms</h1>
            <a href="{{ route('classrooms.create') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg shadow-md transition">
                + Add Classroom
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-600 text-white p-3 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto bg-gray-800 shadow-md rounded-lg">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-700 text-gray-300 uppercase text-sm">
                    <tr>
                        <th class="px-4 py-3 text-left">ID</th>
                        <th class="px-4 py-3 text-left">Name</th>
                        <th class="px-4 py-3 text-left">Section</th>
                        <th class="px-4 py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700 text-gray-200">
                    @foreach ($classrooms as $class)
                        <tr class="hover:bg-gray-700 transition">
                            <td class="px-4 py-2">{{ $class->id }}</td>
                            <td class="px-4 py-2">{{ $class->name }}</td>
                            <td class="px-4 py-2">{{ $class->section ?? '-' }}</td>
                            <td class="px-4 py-2 text-center space-x-2">
                        <a href="{{ route('classrooms.show', $class->id) }}" class="text-green-400 hover:text-green-600 transition">View</a>

                                <a href="{{ route('classrooms.edit', $class->id) }}"
                                    class="text-blue-400 hover:text-blue-600">Edit</a>

                                <form action="{{ route('classrooms.destroy', $class) }}" method="POST"
                                    class="inline-block"
                                    onsubmit="return confirm('Are you sure you want to delete this classroom?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-400 hover:text-red-600">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4 text-gray-400">
            {{ $classrooms->links() }}
        </div>
    </div>
</x-app-layout>
