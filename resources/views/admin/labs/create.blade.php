<x-layouts.app :title="__('Tambah Lab')">
    <div class=" py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Tambah Lab Baru</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2">Tambahkan laboratorium baru ke sistem</p>
            </div>

            <!-- Form Card -->
            <div class=" rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <form action="{{ route('admin.labs.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Lab Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Nama Lab
                        </label>
                        <input type="text" name="name" class="w-full px-4 py-3  border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-gray-900 dark:text-white" placeholder="Masukkan nama lab" required>
                    </div>

                    <!-- Location -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Lokasi
                        </label>
                        <input type="text" name="location" class="w-full px-4 py-3  border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-gray-900 dark:text-white" placeholder="Masukkan lokasi lab">
                    </div>

                    <!-- Capacity -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Kapasitas
                        </label>
                        <input type="number" name="capacity" min="0" class="w-full px-4 py-3  border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-gray-900 dark:text-white" placeholder="Jumlah kapasitas">
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3 pt-4">
                        <a href="{{ route('admin.labs.index') }}" class="flex-1 px-4 py-3 text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-xl text-center font-medium transition-colors duration-200">
                            Batal
                        </a>
                        <button type="submit" class="flex-1 px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium transition-colors duration-200 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>