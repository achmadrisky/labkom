<x-layouts.app :title="__('Edit Lab')">
<div class="max-w-3xl mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-6 text-gray-800 dark:text-white">Edit Lab</h1>

    <form action="{{ route('admin.labs.update', $lab->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Lab Name</label>
            <input type="text" name="name" value="{{ $lab->name }}" class="w-full border rounded-lg px-3 py-2 dark:border-gray-700" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Location</label>
            <input type="text" name="location" value="{{ $lab->location }}" class="w-full border rounded-lg px-3 py-2 dark:border-gray-700">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Capacity</label>
            <input type="number" name="capacity" value="{{ $lab->capacity }}" min="0" class="w-full border rounded-lg px-3 py-2 dark:border-gray-700">
        </div>

        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
            Update
        </button>
        <a href="{{ route('admin.labs.index') }}" class="text-gray-600 dark:text-gray-400 ml-3">Cancel</a>
    </form>
</div>
</x-layouts.app>
