<x-layouts.app :title="__('Buat Booking Baru')">
    <div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Buat Booking Baru</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2">Buat booking laboratorium untuk dosen</p>
            </div>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 rounded-xl">
                    <div class="flex items-center space-x-2 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium">Terdapat kesalahan dalam pengisian form:</span>
                    </div>
                    <ul class="list-disc ml-5 space-y-1 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Card -->
            <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <form action="{{ route('admin.bookings.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Lab Selection -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Pilih Laboratorium
                        </label>
                        <select name="lab_id" class="w-full px-4 py-3 bg-white dark:bg-neutral-800 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-gray-900 dark:text-white" required>
                            <option value="">Pilih Laboratorium</option>
                            @foreach($labs as $lab)
                                <option value="{{ $lab->id }}">{{ $lab->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Course Selection -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Pilih Mata Kuliah
                        </label>
                        <select name="course_id" class="w-full px-4 py-3 bg-white dark:bg-neutral-800 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-gray-900 dark:text-white">
                            <option value="">Pilih Mata Kuliah</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->code }} - {{ $course->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Lecturer Selection -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Assign ke Dosen
                        </label>
                        <select name="requester_id" class="w-full px-4 py-3 bg-white dark:bg-neutral-800 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-gray-900 dark:text-white" required>
                            <option value="">Pilih Dosen</option>
                            @foreach($lecturers as $lecturer)
                                <option value="{{ $lecturer->id }}">{{ $lecturer->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Date and Time -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Date -->
                        <div class="md:col-span-3">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Tanggal
                            </label>
                            <input type="date" name="date" class="w-full px-4 py-3 bg-white dark:bg-neutral-800 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-gray-900 dark:text-white" required>
                        </div>
                        
                        <!-- Start Time -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Mulai
                            </label>
                            <input type="time" name="start_time" class="w-full px-4 py-3 bg-white dark:bg-neutral-800 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-gray-900 dark:text-white" required>
                        </div>
                        
                        <!-- End Time -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Selesai
                            </label>
                            <input type="time" name="end_time" class="w-full px-4 py-3 bg-white dark:bg-neutral-800 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-gray-900 dark:text-white" required>
                        </div>
                    </div>

                    <!-- Purpose -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Tujuan / Deskripsi
                        </label>
                        <textarea name="purpose" rows="3" class="w-full px-4 py-3 bg-white dark:bg-neutral-800 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-gray-900 dark:text-white" placeholder="Masukkan tujuan penggunaan lab"></textarea>
                    </div>

                    <!-- Repeat Weekly -->
                    <div>
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="repeat_weekly" value="1"
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <span class="text-sm text-gray-700 dark:text-gray-300">
                                Ulangi jadwal ini setiap minggu
                            </span>
                        </label>
                        <p class="text-xs text-gray-500 dark:text-gray-400 ml-6 mt-1">
                            Jika dicentang, jadwal akan otomatis dibuat ulang di hari dan jam yang sama setiap minggu.
                        </p>
                    </div>


                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Status
                        </label>
                        <select name="status" class="w-full px-4 py-3 bg-white dark:bg-neutral-800 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-gray-900 dark:text-white">
                            <option value="approved" selected>Disetujui</option>
                            <option value="pending">Menunggu</option>
                            <option value="rejected">Ditolak</option>
                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3 pt-4">
                        <a href="{{ url()->previous() }}" 
                           class="flex-1 px-4 py-3 text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-xl text-center font-medium transition-colors duration-200">
                            Batal
                        </a>
                        <button type="submit" 
                                class="flex-1 px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium transition-colors duration-200 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Simpan Booking
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>