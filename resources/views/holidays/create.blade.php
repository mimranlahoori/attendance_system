<x-app-layout><x-slot name="header"><h2 class="font-semibold text-xl text-gray-200">Add New Holiday</h2></x-slot><div class="py-6 px-6">
    <form action="{{ route('holidays.store') }}" method="POST"
          class="space-y-4 bg-gray-800 p-6 rounded-lg">
        @csrf

        {{-- Display general validation errors --}}
        @if ($errors->any())
            <div class="bg-red-500 text-white p-3 rounded-md mb-4">
                <p class="font-bold">Please correct the following errors:</p>
                <ul class="list-disc list-inside mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div>
            <label for="title" class="block text-gray-300 mb-1">Title <span class="text-red-400">*</span></label>
            {{-- HTML5 required and value persistence --}}
            <input type="text" name="title" id="title" value="{{ old('title') }}"
                   class="w-full bg-gray-700 text-white rounded-md p-2 border @error('title') border-red-500 @enderror"
                   required maxlength="255">
            @error('title')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="date" class="block text-gray-300 mb-1">Date <span class="text-red-400">*</span></label>
            {{-- HTML5 required and value persistence --}}
            <input type="date" name="date" id="date" value="{{ old('date') }}"
                   class="w-full bg-gray-700 text-white rounded-md p-2 border @error('date') border-red-500 @enderror"
                   required>
            @error('date')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="type" class="block text-gray-300 mb-1">Type <span class="text-red-400">*</span></label>
            <select name="type" id="type"
                    class="w-full bg-gray-700 text-white rounded-md p-2 border @error('type') border-red-500 @enderror"
                    required>
                <option value="public" @selected(old('type') == 'public' || !old('type'))>Public Holiday</option>
                <option value="weekend" @selected(old('type') == 'weekend')>Weekend Holiday</option>
                <option value="special" @selected(old('type') == 'special')>Special</option>
                <option value="others" @selected(old('type') == 'others')>Others</option>
            </select>
            @error('type')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="description" class="block text-gray-300 mb-1">Description</label>
            <textarea name="description" id="description" rows="3"
                      class="w-full bg-gray-700 text-white rounded-md p-2 border @error('description') border-red-500 @enderror"
                      maxlength="255">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end pt-2">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-md transition duration-150 ease-in-out shadow-lg">
                Save Holiday
            </button>
        </div>
    </form>
</div>
</x-app-layout>
