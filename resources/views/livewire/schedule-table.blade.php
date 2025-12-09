<!-- belum di pakai -->
<div class="p-4">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-3">
        <h2 class="text-xl font-bold">
            Jadwal ({{ $start->format('d M Y') }} - {{ $end->format('d M Y') }})
        </h2>

        {{-- Switch Mode --}}
        <div class="flex gap-2">
            <button wire:click="$set('viewMode','week')"
                class="px-3 py-1 rounded {{ $viewMode==='week' ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-gray-700 dark:text-white' }}">
                Mingguan
            </button>
            <button wire:click="$set('viewMode','month')"
                class="px-3 py-1 rounded {{ $viewMode==='month' ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-gray-700 dark:text-white' }}">
                Bulanan
            </button>
        </div>
    </div>

    {{-- Tampilan Mingguan --}}
    @if($viewMode === 'week')
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-3">
            @foreach($days as $day)
                <div class="border rounded-lg p-3 bg-white dark:bg-neutral-700 shadow-sm">
                    <div class="flex justify-between items-center mb-2">
                        <span class="font-semibold text-sm">{{ $day->translatedFormat('D') }}</span>
                        <span class="text-xs text-gray-500">{{ $day->format('d M') }}</span>
                    </div>

                    @php $dayBookings = $bookings->where('date', $day->toDateString()); @endphp

                    @forelse($dayBookings as $b)
                        <div class="mb-2 p-2 rounded bg-blue-100 dark:bg-blue-900">
                            <p class="font-bold text-sm truncate">{{ $b->course->name ?? '—' }}</p>
                            <p class="text-xs">{{ $b->lab->name ?? '-' }}</p>
                            <p class="text-xs">
                                {{ \Carbon\Carbon::parse($b->start_time)->format('H:i') }} - 
                                {{ \Carbon\Carbon::parse($b->end_time)->format('H:i') }}
                            </p>
                            <p class="text-[11px] text-gray-600 dark:text-gray-400">{{ $b->user->name ?? '—' }}</p>
                        </div>
                    @empty
                        <p class="text-xs text-gray-400">Tidak ada jadwal</p>
                    @endforelse
                </div>
            @endforeach
        </div>

        {{-- Navigasi Mingguan --}}
        <div class="flex flex-wrap justify-center gap-2 mt-6">
            <button wire:click="previousWeek" class="px-3 py-1 bg-gray-600 text-white rounded">← Minggu Sebelumnya</button>
            <button wire:click="goToCurrentWeek" class="px-3 py-1 bg-gray-500 text-white rounded">Minggu Ini</button>
            <button wire:click="nextWeek" class="px-3 py-1 bg-gray-600 text-white rounded">Minggu Berikutnya →</button>
        </div>
    @endif

    {{-- Tampilan Bulanan --}}
    @if($viewMode === 'month')
        <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-7 gap-2">
            @foreach($days as $day)
                <div class="h-32 border rounded-lg p-2 bg-white dark:bg-neutral-900 shadow-sm overflow-y-auto">
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-xs font-semibold">{{ $day->translatedFormat('D') }}</span>
                        <span class="text-xs text-gray-500">{{ $day->format('d') }}</span>
                    </div>

                    @php $dayBookings = $bookings->where('date', $day->toDateString()); @endphp

                    @forelse($dayBookings as $b)
                        <div class="mb-1 p-1 rounded bg-blue-100 dark:bg-blue-900">
                            <p class="text-xs font-bold truncate">{{ $b->course->name ?? '—' }}</p>
                            <p class="text-[10px] truncate">
                                {{ \Carbon\Carbon::parse($b->start_time)->format('H:i') }} - 
                                {{ \Carbon\Carbon::parse($b->end_time)->format('H:i') }}
                            </p>
                            <p class="text-[10px] text-gray-600 dark:text-gray-400 truncate">
                                {{ $b->user->name ?? '—' }}
                            </p>
                        </div>
                    @empty
                        <p class="text-[10px] text-gray-400">Kosong</p>
                    @endforelse
                </div>
            @endforeach
        </div>

        {{-- Navigasi Bulanan --}}
        <div class="flex flex-wrap justify-center gap-2 mt-6">
            <button wire:click="previousMonth" class="px-3 py-1 bg-gray-600 text-white rounded">← Bulan Sebelumnya</button>
            <button wire:click="goToCurrentMonth" class="px-3 py-1 bg-gray-500 text-white rounded">Bulan Ini</button>
            <button wire:click="nextMonth" class="px-3 py-1 bg-gray-600 text-white rounded">Bulan Berikutnya →</button>
        </div>
    @endif
</div>
