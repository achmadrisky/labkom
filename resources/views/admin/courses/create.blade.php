<x-layouts.app :title="__('Tambah Mata Kuliah')">
    <div class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Tambah Mata Kuliah</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2">Tambahkan mata kuliah baru ke sistem</p>
            </div>

            <!-- Form Card -->
            <div class=" rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <form method="POST" action="{{ route('admin.courses.store') }}" class="space-y-6">
                    @csrf
                    
                    <!-- Kode Mata Kuliah -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Kode Mata Kuliah
                        </label>
                        <input type="text" name="code" class="w-full px-4 py-3 bg-white dark:bg-neutral-800 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-gray-900 dark:text-white" 
                               placeholder="masukan kode matkul" required>
                        @error('code')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama Mata Kuliah -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Nama Mata Kuliah
                        </label>
                        <input type="text" name="name" class="w-full px-4 py-3 bg-white dark:bg-neutral-800 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-gray-900 dark:text-white" 
                               placeholder="masukan mata kuliah" required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>


                    <!-- SKS -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            SKS
                        </label>
                        <select name="sks" class="w-full px-4 py-3 bg-white dark:bg-neutral-800 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-gray-900 dark:text-white" required>
                            <option value="">Pilih SKS</option>
                            <option value="2">2 SKS</option>
                            <option value="3">3 SKS</option>
                            <option value="4">4 SKS</option>
                        </select>
                        @error('sks')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Dosen Pengampu -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Dosen Pengampu
                        </label>
                        <select name="lecturer_id" class="w-full px-4 py-3 bg-white dark:bg-neutral-800 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-gray-900 dark:text-white">
                            <option value="">Pilih Dosen</option>
                            @foreach($lecturers as $lecturer)
                                <option value="{{ $lecturer->id }}">{{ $lecturer->name }}</option>
                            @endforeach
                        </select>
                        @error('lecturer_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                
                    <!-- Action Buttons -->
                    <div class="flex gap-3 pt-4">
                        <a href="{{ route('admin.courses.index') }}" class="flex-1 px-4 py-3 text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-xl text-center font-medium transition-colors duration-200">
                            Batal
                        </a>
                        <button type="submit" class="flex-1 px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium transition-colors duration-200 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Simpan Mata Kuliah
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>