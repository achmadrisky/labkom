<x-layouts.app :title="__('Lecturer Dashboard')">
    <div class="min-h-screen p-4 md:p-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Lecturers Dashboard</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Welcome back, {{ $user->name }}</p>
            </div>
            <div class="text-sm text-gray-500 dark:text-gray-400 ">
                {{ now()->translatedFormat('l, d F Y') }}
            </div>
        </div>

        <!-- Main Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column -->
            <div class="lg:col-span-2 space-y-6">
                <!-- My Courses -->
                <div class=" border dark:border-gray-600 rounded-xl shadow-sm p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-white">My Courses Today</h2>
                        <span class="text-xs bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-2 py-1 rounded-full">
                            {{ ($myCourses ?? collect())->count() }} courses
                        </span>
                    </div>

                    @if(($myCourses ?? collect())->isNotEmpty())
                        <div class="space-y-3">
                            @foreach($myCourses as $course)
                                <div class="flex items-center justify-between p-3 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-colors duration-200 ">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center border border-blue-200 dark:border-blue-800">
                                            <span class="text-blue-600 dark:text-blue-300 font-medium text-sm">{{ substr($course->code, 0, 4) }}</span>
                                        </div>
                                        <div>
                                            <h3 class="font-medium text-gray-900 dark:text-white">{{ $course->name }}</h3>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $course->sks }} sks</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 ">
                            <div class="w-16 h-16 mx-auto mb-3 bg-gray-100 dark:bg-gray-600 rounded-full flex items-center justify-center border border-gray-200 dark:border-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-1">No courses assigned</h3>
                            <p class="text-gray-500 dark:text-gray-300">You don't have any courses assigned yet.</p>
                        </div>
                    @endif
                </div>

                <!-- Timetable -->
                <div class="rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-6">Timetable</h2>

                    {{-- Hari Ini --}}
                    <div class="mb-8">
                        <div class="flex items-center mb-3">
                            <div class="w-3 h-3 bg-blue-500 rounded-full mr-2"></div>
                            <h3 class="font-medium text-gray-700 dark:text-gray-300">
                                Today - {{ $today->format('l, d M Y') }}
                            </h3>
                        </div>

                        @forelse ($todayBookings as $booking)
                            <div class="p-4 mb-3 border-l-4 border-blue-500 bg-blue-50 dark:bg-blue-900/20 rounded-r-lg">
                                <h4 class="font-semibold text-gray-800 dark:text-white">
                                    {{ $booking->course->name ?? 'No Course' }}
                                </h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                    {{ $booking->lab->name ?? 'No Lab' }} · 
                                    {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} -
                                    {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    {{ $booking->purpose ?? 'Regular Class' }}
                                </p>
                            </div>
                        @empty
                            <div class="text-center py-4 text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                <p>No schedule for today.</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- Besok --}}
                    <div>
                        <div class="flex items-center mb-3">
                            <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                            <h3 class="font-medium text-gray-700 dark:text-gray-300">
                                Tomorrow - {{ $tomorrow->format('l, d M Y') }}
                            </h3>
                        </div>

                        @forelse ($tomorrowBookings as $booking)
                            <div class="p-4 mb-3 border-l-4 border-green-500 bg-green-50 dark:bg-green-900/20 rounded-r-lg">
                                <h4 class="font-semibold text-gray-800 dark:text-white">
                                    {{ $booking->course->name ?? 'No Course' }}
                                </h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                    {{ $booking->lab->name ?? 'No Lab' }} · 
                                    {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} -
                                    {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    {{ $booking->purpose ?? 'Regular Class' }}
                                </p>
                            </div>
                        @empty
                            <div class="text-center py-4 text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                <p>No schedule for tomorrow.</p>
                            </div>
                        @endforelse
                    </div>
                </div>


                <!-- Bookings -->
                <div class="rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-white">My Bookings</h2>
                        <div class="flex items-center space-x-2">
                            <span class="text-xs bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-2 py-1 rounded-full">
                                {{ ($myBookings ?? collect())->count() }} bookings
                            </span>
                            <a href="{{ route('lecturer.bookings.create') }}" 
                                class="text-sm bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg transition-colors duration-200 flex items-center space-x-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                <span>New Booking</span>
                            </a>
                        </div>

                    </div>
                    @if(($recentBookings ?? collect())->isNotEmpty())
                            <div class="space-y-3">
                                @foreach($recentBookings as $booking)
                                    <div class="p-4 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                                        <div class="flex justify-between items-start mb-2">
                                            <div>
                                                <h4 class="font-semibold text-gray-900 dark:text-white">
                                                    {{ $booking->lab->name ?? 'Unknown Lab' }}
                                                </h4>
                                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                                    {{ \Carbon\Carbon::parse($booking->date)->format('d M Y') }} 
                                                    · {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                                                </p>
                                            </div>
                                            <span class="text-xs font-medium px-2 py-1 rounded-full 
                                                {{ $booking->status === 'approved' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : 
                                                ($booking->status === 'rejected' ? 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200' : 
                                                'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200') }}">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </div>

                                        @if($booking->course)
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                Course: {{ $booking->course->code }} - {{ $booking->course->name }}
                                            </p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                        <div class="text-center py-8 border border-gray-200 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700/30">
                            <div class="w-16 h-16 mx-auto mb-3 bg-gray-100 dark:bg-gray-600 rounded-full flex items-center justify-center border border-gray-200 dark:border-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-1">No bookings yet</h3>
                            <p class="text-gray-500 dark:text-gray-300 mb-4">You haven't made any bookings yet.</p>
                            <a href="{{ route('lecturer.bookings.create') }}" 
                               class="inline-flex items-center space-x-1 text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 text-sm font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                <span>Create your first booking</span>
                            </a>
                        </div>
                        @endif
                </div>
            </div>

            <!-- Right Column -->
            <div class="hidden lg:block space-y-6">
                <!-- Profile -->
                <div class="p-6 text-center">
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
                        <a href="{{ route('lecturer.bookings.index') }}" class="w-full flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 rounded-lg transition-colors duration-200 border border-gray-200 dark:border-gray-600">
                            <span class="text-gray-700 dark:text-gray-300 font-medium">All Bookings</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="{{ route('lecturer.bookings.create') }}" class="w-full flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 rounded-lg transition-colors duration-200 border border-gray-200 dark:border-gray-600">
                            <span class="text-gray-700 dark:text-gray-300 font-medium">New Booking</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>