<x-layouts.app :title="__('Mata Kuliah')">
    <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded-2xl">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Belanja Mata Kuliah</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Pilih mata kuliah yang ingin Anda ambil semester ini
                    </p>
                </div>
            </div>
            
            <!-- Stats -->
            <div class="flex items-center gap-6  rounded-xl p-4 border border-gray-200 dark:border-gray-700">
                <div class="text-center">
                    <div class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ count($myCourses) }}</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">Diambil</div>
                </div>
                <div class="h-8 w-px bg-gray-300 dark:bg-gray-600"></div>
                <div class="text-center">
                    <div class="text-lg font-bold text-gray-600 dark:text-gray-400">{{ $courses->count() }}</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">Total</div>
                </div>
            </div>
        </div>

        <!-- Course List -->
        <div class="space-y-4">
            @foreach($courses as $course)
                <div class="flex flex-col sm:flex-row sm:items-center justify-between p-6 border border-gray-200 dark:border-gray-700 rounded-2xl hover:shadow-lg transition-all duration-200">
                    <!-- Course Info -->
                    <div class="flex-1 mb-4 sm:mb-0">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
                                <span class="text-white font-bold text-sm">{{ substr($course->code, 0, 3) }}</span>
                            </div>
                            <div class="flex-1">
                                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">
                                    {{ $course->name }}
                                </h2>
                                <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 dark:text-gray-400">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        {{ $course->code }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                        {{ $course->sks }} SKS
                                    </span>
                                    @if($course->lecturer_id)
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                            {{ $course->lecturer->name ?? '-' }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <div class="flex-shrink-0">
                        @if(in_array($course->id, $myCourses))
                            <form action="{{ route('enrollments.drop', $course->id) }}" method="POST" class="flex justify-end">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="flex items-center gap-2 px-5 py-2.5 bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 border border-red-200 dark:border-red-800 rounded-xl hover:bg-red-100 dark:hover:bg-red-900/30 transition-all duration-200 font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Batalkan
                                </button>
                            </form>
                        @else
                            <form action="{{ route('enrollments.enroll', $course->id) }}" method="POST" class="flex justify-end">
                                @csrf
                                <button type="submit" 
                                        class="flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-all duration-200 font-medium shadow-sm hover:shadow-md">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    Ambil
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Empty State -->
        @if($courses->count() === 0)
            <div class="text-center py-12">
                <div class="w-24 h-24 mx-auto mb-4 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Tidak ada mata kuliah</h3>
                <p class="text-gray-500 dark:text-gray-400 text-sm">
                    Belum ada mata kuliah yang tersedia untuk semester ini.
                </p>
            </div>
        @endif
    </div>
</x-layouts.app>