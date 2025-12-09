<x-layouts.app :title="__('Student Dashboard')">
    <div class="min-h-screen p-4 md:p-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Dashboard</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Welcome back, {{ $user->name }}</p>
            </div>
            <div class="text-sm text-gray-500 dark:text-gray-400  px-4 py-2">
                {{ now()->translatedFormat('l, d F Y') }}
            </div>
        </div>

        <!-- Main Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column -->
            <div class="lg:col-span-2 space-y-6">
                <!-- My Classes -->
               <div class="border dark:border-gray-600 rounded-xl shadow-sm p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-white">My Classes</h2>
                        <span class="text-xs bg-blue-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200 px-2 py-1 rounded-full">
                            {{ count($myCourses) }} classes
                        </span>
                    </div>

                    @if(count($myCourses) > 0)
                        <div class="space-y-3">
                            @foreach($myCourses as $course)
                                <div class="flex items-center justify-between p-3 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-colors duration-200">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                                            <span class="text-blue-600 dark:text-blue-300 font-medium text-sm">
                                                {{ substr($course->code, 0, 4) }}
                                            </span>
                                        </div>
                                        <div>
                                            <h3 class="font-medium text-gray-900 dark:text-white">{{ $course->name }}</h3>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                {{ $course->lecturer->name ?? 'No lecturer assigned' }}
                                            </p>
                                        </div>
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="w-16 h-16 mx-auto mb-3 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l-9 5m9-5v9" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-1">No classes found</h3>
                            <p class="text-gray-500 dark:text-gray-400 mb-4">
                                You are not enrolled in any classes yet.
                            </p>
                            <a href="{{ route('enrollments.index') }}" 
                               class="inline-flex items-center space-x-1 text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 text-sm font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                <span>add your first courses</span>
                            </a>
                        </div>
                    @endif
                </div>


               <!-- Timetable -->
                <div class="border dark:border-gray-600 rounded-xl shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Timetable</h2>

                    <!-- Today -->
                    <div class="mb-6">
                        <div class="flex items-center mb-3">
                            <div class="w-3 h-3 bg-blue-500 rounded-full mr-2"></div>
                            <h3 class="font-medium text-gray-700 dark:text-gray-300">
                                Today - {{ $today->format('d M') }}
                            </h3>
                        </div>

                        @forelse($todayBookings as $booking)
                            <div class="p-3 border-l-4 border-blue-500 bg-blue-50 dark:bg-blue-900/20 rounded-r-lg">
                                <h4 class="font-semibold text-gray-800 dark:text-white">
                                    {{ $booking->course->name ?? 'No Course' }}
                                </h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                    {{ $booking->requester->name ?? 'No Lecturer' }} · 
                                    {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} -
                                    {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                                </p>
                                <div class="flex items-center mt-2 text-xs text-gray-500 dark:text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    {{ $booking->lab->name ?? 'No Lab' }}
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4 text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                <p>No schedule for today</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Tomorrow -->
                    <div>
                        <div class="flex items-center mb-3">
                            <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                            <h3 class="font-medium text-gray-700 dark:text-gray-300">
                                Tomorrow - {{ $tomorrow->format('d M') }}
                            </h3>
                        </div>

                        @forelse($tomorrowBookings as $booking)
                            <div class="p-3 border-l-4 border-green-500 bg-green-50 dark:bg-green-900/20 rounded-r-lg">
                                <h4 class="font-semibold text-gray-800 dark:text-white">
                                    {{ $booking->course->name ?? 'No Course' }}
                                </h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                    {{ $booking->requester->name ?? 'No Lecturer' }} · 
                                    {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} -
                                    {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                                </p>
                                <div class="flex items-center mt-2 text-xs text-gray-500 dark:text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    {{ $booking->lab->name ?? 'No Lab' }}
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4 text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                <p>No schedule for tomorrow</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-6">
               <!-- Profile -->
                <div class="rounded-xl p-6 text-center">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-white font-semibold text-xl">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </span>
                    </div>
                    <h3 class="font-semibold text-gray-800 dark:text-white text-lg">{{ $user->name }}</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">{{ ucfirst($user->role) }}</p>

                    <a href="{{ route('profile.edit') }}"
                    class="w-full block bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 
                            text-gray-800 dark:text-white py-2 rounded-lg text-sm font-medium text-center 
                            transition-colors duration-200">
                        View Profile
                    </a>
                </div>

                <!-- Calendar -->
                <div class="rounded-xl p-6">
                    <livewire:calendar />
                </div>
                
                 <!-- Quick Actions -->
                <div class="p-6">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Quick Actions</h2>
                    <div class="space-y-3">
                        <a href="{{ route('enrollments.index') }}" class="w-full flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 rounded-lg transition-colors duration-200 border border-gray-200 dark:border-gray-600">
                            <span class="text-gray-700 dark:text-gray-300 font-medium">My Course</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="{{ route('schedule.index') }}" class="w-full flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 rounded-lg transition-colors duration-200 border border-gray-200 dark:border-gray-600">
                            <span class="text-gray-700 dark:text-gray-300 font-medium">Schedule</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
            </div>
        </div>
    </div>
</x-layouts.app>
