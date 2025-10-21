<x-app-layout>
    <div class="max-w-4xl mx-auto py-8">
        <h1 class="text-2xl font-bold text-gray-100 mb-6">➕ Add New Classroom</h1>

        @if ($errors->any())
            <div class="bg-red-700 text-white p-3 rounded-lg mb-4">
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('classrooms.store') }}" method="POST"
            class="bg-gray-800 p-6 rounded-lg shadow-lg space-y-4">
            @csrf

            <div>
                <label class="block text-gray-300 mb-2">Class Name</label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="w-full bg-gray-700 text-white p-3 rounded-lg border border-gray-600 focus:ring focus:ring-indigo-500">
            </div>

            <div>
                <label class="block text-gray-300 mb-2">Section</label>
                <input type="text" name="section" value="{{ old('section') }}"
                    class="w-full bg-gray-700 text-white p-3 rounded-lg border border-gray-600 focus:ring focus:ring-indigo-500">
            </div>

            <div class="flex justify-end">
                <a href="{{ route('classrooms.index') }}"
                    class="px-4 py-2 bg-gray-600 hover:bg-gray-500 text-white rounded-lg mr-2">Back</a>
                <button type="submit"
                    class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg">Save</button>
            </div>
        </form>
    </div>
</x-app-layout>
