<x-layouts.app :title="__('Ajukan Booking Lab')">
    <div class="max-w-3xl mx-auto p-6 ">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Create New Booking</h1>

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

        <form action="{{ route('lecturer.bookings.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Pilih Lab --}}
            <div>
                <label for="lab_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Laboratorium</label>
                <select name="lab_id" id="lab_id" required
                    class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 bg-white dark:bg-neutral-800 text-gray-900 dark:text-white">
                    <option value="">-- Pilih Lab --</option>
                    @foreach($labs as $lab)
                        <option value="{{ $lab->id }}">{{ $lab->name }}</option>
                    @endforeach
                </select>
                @error('lab_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Pilih Mata Kuliah --}}
            <div>
                <label for="course_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Mata Kuliah</label>
                <select name="course_id" id="course_id"
                    class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 bg-white dark:bg-neutral-800 text-gray-900 dark:text-white">
                    <option value="">-- Pilih Mata Kuliah --</option>
                    @foreach($courses->where('lecturer_id', Auth::id()) as $course)
                        <option value="{{ $course->id }}">{{ $course->code }} - {{ $course->name }}</option>
                    @endforeach
                </select>
                @error('course_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tanggal --}}
            <div>
                <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tanggal</label>
                <input type="date" name="date" id="date" required
                    class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 bg-white dark:bg-neutral-800 text-gray-900 dark:text-white"
                    min="{{ \Carbon\Carbon::today()->format('Y-m-d') }}">
                @error('date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Jam Mulai dan Selesai --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="start_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jam Mulai</label>
                    <input type="time" name="start_time" id="start_time" required
                        class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 bg-white dark:bg-neutral-800 text-gray-900 dark:text-white">
                    @error('start_time')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="end_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jam Selesai</label>
                    <input type="time" name="end_time" id="end_time" required
                        class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 bg-white dark:bg-neutral-800 text-gray-900 dark:text-white">
                    @error('end_time')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- SKS & Durasi --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="sks" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jumlah SKS</label>
                    <input type="number" name="sks" id="sks" min="1" max="4" required
                        class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 bg-white dark:bg-neutral-800 text-gray-900 dark:text-white">
                    @error('sks')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="duration_minutes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Durasi (menit)</label>
                    <input type="number" name="duration_minutes" id="duration_minutes" min="30" step="15" required
                        class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 bg-white dark:bg-neutral-800 text-gray-900 dark:text-white">
                    @error('duration_minutes')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Tujuan/Purpose --}}
            <div>
                <label for="purpose" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tujuan Booking</label>
                <textarea name="purpose" id="purpose" rows="3"
                    class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 bg-white dark:bg-neutral-800 text-gray-900 dark:text-white"
                    placeholder="Contoh: Praktikum Pemrograman Web Lanjutan..."></textarea>
                @error('purpose')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-end items-center space-x-3">
                <a href="{{ route('lecturer.dashboard') }}" 
                class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors duration-200">
                    Batal
                </a>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200">
                    Simpan Booking
                </button>
            </div>
        </form>
    </div>

</x-layouts.app>