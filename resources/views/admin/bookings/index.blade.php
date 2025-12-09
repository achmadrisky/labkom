<x-layouts.app :title="__('Manage Bookings')">
    <div class="min-h-screen p-4 md:p-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Manage Bookings</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Approve, reject, or delete booking requests
                </p>
            </div>

            <div class="flex items-center gap-3">
                <!-- Tombol tambah booking -->
                <a href="{{ route('admin.bookings.create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm transition-colors duration-200">
                    + New Booking
                </a>

                <!-- Jumlah total booking -->
                <span class="text-xs bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-3 py-1 rounded-full">
                    {{ $bookings->count() }} total bookings
                </span>
            </div>
        </div>


        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 dark:bg-green-900 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        <!-- Filter & Search -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
            <form method="GET" action="{{ route('admin.bookings.index') }}" class="flex flex-wrap items-center gap-3 w-full sm:w-auto">

                <!-- Search -->
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

                <!-- Filter by Date -->
                <input type="date" name="date" value="{{ request('date') }}"
                    class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl  text-gray-700 dark:text-gray-200" />

                <!-- Filter by Month -->
                <input type="month" name="month" value="{{ request('month') }}"
                    class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl  text-gray-700 dark:text-gray-200" />
                
                <!-- Submit Button -->
                <div class="flex items-center gap-2">
                    <button type="submit" 
                            class="flex items-center gap-2 px-4 py-3 text-sm bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"/>
                        </svg>
                        <span class="hidden sm:inline">Filter</span>
                    </button>

                    <!-- Reset -->
                    <a href="{{ route('admin.bookings.index') }}"
                    class="flex items-center gap-2 px-4 py-3 text-sm bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        <span class="hidden sm:inline">Reset</span>
                    </a>
                </div>
            </form>
        </div>


        <!-- Table Container -->
        <div class=" rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <div class="min-w-[800px]"> <!-- Minimum width untuk mobile scroll -->
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-700">
                                <th class="px-3 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider whitespace-nowrap">ID</th>
                                <th class="px-3 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider whitespace-nowrap">Requester</th>
                                <th class="px-3 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider whitespace-nowrap">Lab</th>
                                <th class="px-3 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider whitespace-nowrap">Course</th>
                                <th class="px-3 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider whitespace-nowrap">Date</th>
                                <th class="px-3 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider whitespace-nowrap">Time</th>
                                <th class="px-3 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider whitespace-nowrap">Status</th>
                                <th class="px-3 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider whitespace-nowrap">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($bookings as $booking)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                                    <td class="px-3 sm:px-4 py-3 text-sm text-gray-900 dark:text-white whitespace-nowrap">
                                        #{{ $booking->id }}
                                    </td>
                                    <td class="px-3 sm:px-4 py-3 text-sm text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ $booking->requester->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-3 sm:px-4 py-3 text-sm text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ $booking->lab->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-3 sm:px-4 py-3 text-sm text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ $booking->course->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-3 sm:px-4 py-3 text-sm text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($booking->date)->format('M d, Y') }}
                                    </td>
                                    <td class="px-3 sm:px-4 py-3 text-sm text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                                    </td>
                                    <td class="px-3 sm:px-4 py-3 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $booking->status === 'approved' 
                                                ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200'
                                                : ($booking->status === 'pending' 
                                                    ? 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200'
                                                    : 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200') }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                    <td class="px-3 sm:px-4 py-3 whitespace-nowrap">
                                        <div class="flex flex-col sm:flex-row gap-1 sm:gap-2">
                                            @if($booking->status === 'pending')
                                                <form action="{{ route('admin.bookings.approve', $booking->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="w-full sm:w-auto text-xs px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors duration-200">
                                                        Approve
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.bookings.reject', $booking->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="w-full sm:w-auto text-xs px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors duration-200">
                                                        Reject
                                                    </button>
                                                </form>
                                            @endif
                                            <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-full sm:w-auto text-xs px-3 py-1.5 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors duration-200" 
                                                    onclick="return confirm('Are you sure you want to delete this booking?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                        <div class="flex flex-col items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <p class="text-lg font-medium text-gray-900 dark:text-white mb-1">No bookings found</p>
                                            <p class="text-sm">There are no booking requests to manage.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        
    </div>
    <div class="p-4 border-t border-gray-200 dark:border-gray-700">
        {{ $bookings->links('pagination::tailwind') }}
    </div>
</x-layouts.app>