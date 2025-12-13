<x-layouts.app :title="__('Dashboard Schedule')">
    <div class="p-4 md:p-6">
        <!-- Header -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-8 gap-4">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded-2xl">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-white">
                        Jadwal Mingguan Laboratorium
                    </h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Periode: {{ $startOfWeek->format('d M') }} - {{ $endOfWeek->format('d M Y') }}
                    </p>
                </div>
            </div>
            
           <!-- Search and Navigation -->
            <div class="flex flex-col sm:flex-row gap-4">

                <!-- Week Navigation -->
                <div class="flex items-center gap-2">

                    {{-- 🔙 Previous Week --}}
                    <a href="{{ route('schedule.index', array_merge(request()->query(), ['week' => $startOfWeek->copy()->subWeek()->format('Y-m-d')])) }}"
                    class="flex items-center gap-1 sm:gap-2 px-3 py-1.5 sm:px-4 sm:py-2 rounded-lg bg-white dark:bg-gray-800 
                            border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 
                            hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                          <span class="text-xs sm:text-sm">
                            <span class="hidden sm:inline">Previous</span>
                            <span class="sm:hidden">Prev</span>
                        </span>
                    </a>

                    {{-- 📅 Current Week --}}
                    <a href="{{ route('schedule.index') }}"
                    class="flex items-center gap-1 sm:gap-2 px-3 py-1.5 sm:px-4 sm:py-2 rounded-lg bg-gray-100 dark:bg-gray-700 
                            border border-gray-300 dark:border-gray-600 text-gray-800 dark:text-gray-200 
                            hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-xs sm:text-sm">
                            <span class="hidden sm:inline">Current Week</span>
                            <span class="sm:hidden">Today</span>
                        </span>
                    </a>

                    {{-- 🔜 Next Week --}}
                    <a href="{{ route('schedule.index', array_merge(request()->query(), ['week' => $startOfWeek->copy()->addWeek()->format('Y-m-d')])) }}"
                    class="flex items-center gap-1 sm:gap-2 px-3 py-1.5 sm:px-4 sm:py-2  rounded-lg bg-blue-800 hover:bg-blue-700 
                            text-white transition">
                         <span class="text-xs sm:text-sm">
                            <span class="hidden sm:inline">Next</span>
                            <span class="sm:hidden">Next</span>
                        </span>
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>

        </div>

        <!-- Weekly Schedule by Day -->
        <div class="space-y-6">
            @foreach (['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $day)
                @php
                    $indonesianDay = [
                        'Monday' => 'Senin',
                        'Tuesday' => 'Selasa', 
                        'Wednesday' => 'Rabu',
                        'Thursday' => 'Kamis',
                        'Friday' => 'Jumat',
                        'Saturday' => 'Sabtu',
                        'Sunday' => 'Minggu'
                    ][$day];
                    $dayDate = $startOfWeek->copy()->startOfWeek()->addDays(array_search($day, ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday']));
                @endphp
                
                <!-- Day Section -->
                <div class="rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <!-- Day Header - Outside Table -->
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-blue-50 dark:from-gray-700 dark:to-blue-900/20 border-b border-gray-200 dark:border-gray-600">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-2 h-8 bg-blue-500 rounded-full"></div>
                                <div>
                                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
                                        {{ $indonesianDay }}
                                    </h2>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $dayDate->format('d F Y') }}
                                    </p>
                                </div>
                            </div>
                            <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 text-sm font-medium rounded-full">
                                {{ isset($bookingsByDay[$day]) ? count($bookingsByDay[$day]) : 0 }} Jadwal
                            </span>
                        </div>
                    </div>

                    <!-- Schedule Table for the Day -->
                    @if(isset($bookingsByDay[$day]) && count($bookingsByDay[$day]) > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-50 dark:bg-gray-700/50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Waktu
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Mata Kuliah
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Dosen
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Laboratorium
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Status
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($bookingsByDay[$day] as $booking)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center gap-2">
                                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    <span class="text-gray-900 dark:text-white font-mono text-sm">
                                                        {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="font-medium text-gray-900 dark:text-white">
                                                    {{ $booking->course->name ?? 'Tidak ada mata kuliah' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-gray-900 dark:text-white">
                                                    {{ $booking->requester->name ?? 'Tidak ada dosen' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-gray-900 dark:text-white">
                                                    {{ $booking->lab->name ?? 'Tidak ada lab' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                                                    {{ $booking->status === 'approved' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : 
                                                       ($booking->status === 'pending' ? 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200' : 
                                                       'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200') }}">
                                                    @if($booking->status === 'approved')
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                        </svg>
                                                    @elseif($booking->status === 'pending')
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                    @else
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                        </svg>
                                                    @endif
                                                    {{ ucfirst($booking->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="px-6 py-12 text-center">
                            <svg class="w-16 h-16 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">
                                Tidak ada jadwal untuk {{ $indonesianDay }}
                            </p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</x-layouts.app>