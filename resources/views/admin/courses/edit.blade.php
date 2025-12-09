<x-layouts.app :title="__('Edit Mata Kuliah')">
    <div class=" py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Mata Kuliah</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2">Perbarui informasi mata kuliah</p>
            </div>

            <!-- Error Alert -->
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-100 dark:bg-red-900 border border-red-200 dark:border-red-700 text-red-700 dark:text-red-300 rounded-xl">
                    <div class="flex items-center mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium">Terdapat kesalahan dalam pengisian form:</span>
                    </div>
                    <ul class="list-disc ml-5 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Card -->
            <div class=" rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <form method="POST" action="{{ route('admin.courses.update', $course->id) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Kode Mata Kuliah -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Kode Mata Kuliah
                        </label>
                        <input type="text" name="code" value="{{ old('code', $course->code) }}"
                               class="w-full px-4 py-3 bg-white dark:bg-neutral-800 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-gray-900 dark:text-white"
                               placeholder="Contoh: TIF101" required>
                    </div>

                    <!-- Nama Mata Kuliah -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Nama Mata Kuliah
                        </label>
                        <input type="text" name="name" value="{{ old('name', $course->name) }}"
                               class="w-full px-4 py-3 bg-white dark:bg-neutral-800 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-gray-900 dark:text-white"
                               placeholder="Contoh: Pemrograman Dasar" required>
                    </div>
                   
                    <!-- SKS -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            SKS
                        </label>
                        <select name="sks" class="w-full px-4 py-3 bg-white dark:bg-neutral-800 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-gray-900 dark:text-white" required>
                            <option value="">Pilih SKS</option>
                            <option value="2" {{ old('sks', $course->sks) == 2 ? 'selected' : '' }}>2 SKS</option>
                            <option value="3" {{ old('sks', $course->sks) == 3 ? 'selected' : '' }}>3 SKS</option>
                            <option value="4" {{ old('sks', $course->sks) == 4 ? 'selected' : '' }}>4 SKS</option>
                        </select>
                    </div>

                    <!-- Dosen Pengampu -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Dosen Pengampu
                        </label>
                        <select name="lecturer_id" class="w-full px-4 py-3 bg-white dark:bg-neutral-800 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-gray-900 dark:text-white">
                            <option value="">Pilih Dosen (Opsional)</option>
                            @foreach($lecturers as $lecturer)
                                <option value="{{ $lecturer->id }}" {{ old('lecturer_id', $course->lecturer_id) == $lecturer->id ? 'selected' : '' }}>
                                    {{ $lecturer->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                 

                    <!-- Action Buttons -->
                    <div class="flex gap-3 pt-4">
                        <a href="{{ route('admin.courses.index') }}" 
                           class="flex-1 px-4 py-3 text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-xl text-center font-medium transition-colors duration-200">
                            Kembali
                        </a>
                        <button type="submit" 
                                class="flex-1 px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium transition-colors duration-200 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Update Mata Kuliah
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>