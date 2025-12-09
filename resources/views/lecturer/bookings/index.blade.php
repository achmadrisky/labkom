<x-layouts.app :title="__('Daftar Booking')">
<div class=" mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">My Bookings</h1>
            <p class="text-sm text-gray-600 dark:text-gray-400">List of lab bookings you’ve made</p>
        </div>
        <a href="{{ route('lecturer.bookings.create') }}" 
           class="flex items-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition-all duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            New Booking
        </a>
    </div>

    {{-- Success message --}}
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <form method="GET" class="flex flex-col sm:flex-row gap-3 mb-6">
        <div class="flex items-center border border-gray-300 dark:border-gray-600 rounded-xl overflow-hidden">
            <input type="text" name="search" value="{{ request('search') }}" 
                placeholder="Cari nama dosen, lab, atau matkul..."
                class="px-4 py-2 text-gray-700 dark:text-gray-200 outline-none w-56" />
            <button type="submit" class="px-3 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </button>
        </div>
        <input type="date" name="date" value="{{ request('date') }}"
            class="px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg 
                 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500" />

        <input type="month" name="month" value="{{ request('month') }}"
            class="px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg 
                 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500" />

         <button type="submit" 
                class="flex items-center gap-2 px-4 py-3 text-sm bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"/>
            </svg>
            <span class="hidden sm:inline">Filter</span>
        </button>
    </form>


    {{-- If no bookings --}}
    @if($bookings->isEmpty())
        <div class="text-center py-10 border dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-800">
            <p class="text-gray-600 dark:text-gray-400">You haven’t made any bookings yet.</p>
            <a href="{{ route('lecturer.bookings.create') }}" 
               class="inline-block mt-3 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Create your first booking
            </a>
        </div>
    @else
        <div class="overflow-x-auto border dark:border-gray-700 rounded-xl shadow">
            <table class="min-w-full text-sm text-left text-gray-700 dark:text-gray-300">
                <thead class="bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3">Date</th>
                        <th class="px-6 py-3">Time</th>
                        <th class="px-6 py-3">Lab</th>
                        <th class="px-6 py-3">Course</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3 text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $booking)
                        <tr class="border-t dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($booking->date)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} - 
                                {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                            </td>
                            <td class="px-6 py-4">{{ $booking->lab->name ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $booking->course->name ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                    {{ $booking->status === 'approved' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 
                                       ($booking->status === 'rejected' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : 
                                       'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200') }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                {{-- Batalkan booking jika masih pending --}}
                                @if($booking->status === 'pending')
                                    <form action="{{ route('lecturer.bookings.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('Cancel this booking?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="px-3 py-1 bg-red-600 text-white rounded-md hover:bg-red-700 text-xs">
                                            Cancel
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400 text-xs italic">No action</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif  
</div>
     <div class="p-4 border-t border-gray-200 dark:border-gray-700">
        {{ $bookings->links('pagination::tailwind') }}
    </div>

</x-layouts.app>
