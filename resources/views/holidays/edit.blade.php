<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200">Edit Holiday</h2>
    </x-slot>

    <div class="py-6 px-6">
        <form action="{{ route('holidays.update', $holiday) }}" method="POST"
              class="space-y-4 bg-gray-800 p-6 rounded-lg">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-gray-300">Title</label>
                <input type="text" name="title" value="{{ $holiday->title }}" class="w-full bg-gray-700 text-white rounded-md p-2" required>
            </div>

            <div>
                <label class="block text-gray-300">Date</label>
                <input type="date" name="date" value="{{ $holiday->date }}" class="w-full bg-gray-700 text-white rounded-md p-2" required>
            </div>

            <div>
                <label class="block text-gray-300">Type</label>
                <select name="type" class="w-full bg-gray-700 text-white rounded-md p-2" required>
                    <option value="public" @selected($holiday->type == 'public')>Public Holiday</option>
                    <option value="school" @selected($holiday->type == 'school')>School Holiday</option>
                    <option value="other" @selected($holiday->type == 'other')>Other</option>
                </select>
            </div>

            <div>
                <label class="block text-gray-300">Description</label>
                <textarea name="description" rows="3" class="w-full bg-gray-700 text-white rounded-md p-2">{{ $holiday->description }}</textarea>
            </div>

            <div class="flex justify-end">
                <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md">
                    Update
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
