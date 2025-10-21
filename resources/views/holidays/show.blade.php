<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200">Holiday Details</h2>
    </x-slot>

    <div class="py-6 px-6">
        <div class="bg-gray-800 p-6 rounded-lg text-gray-100 space-y-3">
            <p><strong>Title:</strong> {{ $holiday->title }}</p>
            <p><strong>Date:</strong> {{ $holiday->date }}</p>
            <p><strong>Type:</strong> {{ ucfirst($holiday->type) }}</p>
            <p><strong>Description:</strong> {{ $holiday->description ?? 'N/A' }}</p>
        </div>

        <div class="mt-4 flex justify-between">
            <a href="{{ route('holidays.index') }}" class="text-blue-400 hover:underline">← Back to list</a>
            <a href="{{ route('holidays.edit', $holiday) }}" class="text-green-400 hover:underline">Edit</a>
        </div>
    </div>
</x-app-layout>
