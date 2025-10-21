<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            Holidays List
        </h2>
    </x-slot>

    <div class="py-6 px-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg text-gray-100">All Holidays</h3>
            <a href="{{ route('holidays.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
               + Add Holiday
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-gray-800 text-white rounded-lg">
                <thead>
                    <tr class="bg-gray-700 text-gray-300">
                        <th class="px-4 py-2 text-left">#</th>
                        <th class="px-4 py-2 text-left">Title</th>
                        <th class="px-4 py-2 text-left">Date</th>
                        <th class="px-4 py-2 text-left">Type</th>
                        <th class="px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($holidays as $holiday)
                        <tr class="border-t border-gray-700">
                            <td class="px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2">{{ $holiday->title }}</td>
                            <td class="px-4 py-2">{{ $holiday->date }}</td>
                            <td class="px-4 py-2 capitalize">{{ $holiday->type }}</td>
                            <td class="px-4 py-2 flex gap-2">
                                <a href="{{ route('holidays.show', $holiday) }}" class="text-green-400 hover:underline">View</a>
                                <a href="{{ route('holidays.edit', $holiday) }}" class="text-blue-400 hover:underline">Edit</a>
                                <form action="{{ route('holidays.destroy', $holiday) }}" method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this holiday?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-400 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-gray-400">No holidays found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
