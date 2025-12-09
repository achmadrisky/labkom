<x-layouts.app :title="__('Ubah Status Booking')">
    <div class="p-6 max-w-lg mx-auto">
        <h1 class="text-2xl font-bold mb-6">Ubah Status Booking</h1>

        <form action="{{ route('lecturer.bookings.update', $booking) }}" method="POST" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block mb-1">Status</label>
                <select name="status" class="w-full border rounded px-3 py-2 dark:bg-neutral-900 dark:border-neutral-700" required>
                    <option value="pending" {{ $booking->status=='pending'?'selected':'' }}>Pending</option>
                    <option value="approved" {{ $booking->status=='approved'?'selected':'' }}>Approved</option>
                    <option value="rejected" {{ $booking->status=='rejected'?'selected':'' }}>Rejected</option>
                </select>
            </div>
            <div class="flex justify-end gap-2">
                <a href="{{ route('lecturer.bookings.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Simpan</button>
            </div>
        </form>
    </div>
</x-layouts.app>
