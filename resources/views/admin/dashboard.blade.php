<x-layouts.app :title="__('Admin Dashboard')">
    <div class="min-h-screen p-4 md:p-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Admin Dashboard</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Overview and management</p>
            </div>
            <div class="text-sm text-gray-500 dark:text-gray-400 px-4 py-2 ">
                {{ now()->translatedFormat('l, d F Y') }}
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Users -->
            <a href="{{ route('admin.users.index') }}" class=" rounded-xl p-6 border border-gray-200 dark:border-gray-700 hover:bg-blue-50 dark:hover:bg-blue-950 transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Users</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-white mt-1">{{ $totalUsers }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Total Labs -->
            <a href="{{ route('admin.labs.index') }}" 
            class="block rounded-xl p-6 border border-gray-200 dark:border-gray-700 hover:bg-green-50 dark:hover:bg-green-950 transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Labs</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-white mt-1">{{ $totalLabs }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                </div>
            </a>


            <!-- Total Courses -->
            <a href="{{ route('admin.courses.index') }}" 
            class="block rounded-xl p-6 border border-gray-200 dark:border-gray-700 hover:bg-purple-50 dark:hover:bg-purple-950 transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Courses</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-white mt-1">{{ $totalCourses }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                </div>
            </a>


            <!-- Total Bookings -->
            <a href="{{ route('admin.bookings.index') }}" 
            class=" rounded-xl p-6 border border-gray-200 dark:border-gray-700 hover:bg-orange-50 dark:hover:bg-orange-950 transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Bookings</p>
                        <p class="text-2xl font-bold text-gray-800 dark:text-white mt-1">{{ $totalBookings }}</p>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-orange-600 dark:text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </a>
        </div>

       <!-- Recent Bookings -->
        <div class=" rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-4 sm:px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Recent Bookings</h2>
                    <span class="text-xs bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-2 py-1 rounded-full">
                        {{ $recentBookings->count() }} bookings
                    </span>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <div class="min-w-[600px]"> <!-- Minimum width untuk memastikan konten tidak terpotong -->
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-700">
                                <th class="px-3 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider whitespace-nowrap">Date</th>
                                <th class="px-3 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider whitespace-nowrap">Course</th>
                                <th class="px-3 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider whitespace-nowrap">Lab</th>
                                <th class="px-3 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider whitespace-nowrap">Requester</th>
                                <th class="px-3 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider whitespace-nowrap">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($recentBookings as $booking)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                                <td class="px-3 sm:px-4 py-3 text-sm text-gray-900 dark:text-white whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($booking->date)->format('M d, Y') }}
                                </td>
                                <td class="px-3 sm:px-4 py-3 text-sm text-gray-900 dark:text-white whitespace-nowrap">
                                    {{ $booking->course->name ?? '-' }}
                                </td>
                                <td class="px-3 sm:px-4 py-3 text-sm text-gray-900 dark:text-white whitespace-nowrap">
                                    {{ $booking->lab->name ?? '-' }}
                                </td>
                                <td class="px-3 sm:px-4 py-3 text-sm text-gray-900 dark:text-white whitespace-nowrap">
                                    {{ $booking->requester->name ?? '-' }}
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
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                    <div class="flex flex-col items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <p class="text-lg font-medium text-gray-900 dark:text-white mb-1">No bookings found</p>
                                        <p class="text-sm">There are no recent bookings to display.</p>
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
</x-layouts.app>