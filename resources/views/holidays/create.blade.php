<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200">Add New Holiday</h2>
    </x-slot>

    <div class="py-6 px-6">
        <form action="{{ route('holidays.store') }}" method="POST"
              class="space-y-4 bg-gray-800 p-6 rounded-lg">
            @csrf

            <div>
                <label class="block text-gray-300">Title</label>
                <input type="text" name="title" class="w-full bg-gray-700 text-white rounded-md p-2" required>
            </div>

            <div>
                <label class="block text-gray-300">Date</label>
                <input type="date" name="date" class="w-full bg-gray-700 text-white rounded-md p-2" required>
            </div>

            <div>
                <label class="block text-gray-300">Type</label>
                <select name="type" class="w-full bg-gray-700 text-white rounded-md p-2" required>
                    <option value="public">Public Holiday</option>
                    <option value="school">School Holiday</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <div>
                <label class="block text-gray-300">Description</label>
                <textarea name="description" rows="3" class="w-full bg-gray-700 text-white rounded-md p-2"></textarea>
            </div>

            <div class="flex justify-end">
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                    Save
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
