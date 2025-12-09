<div class="rounded-xl p-6 ">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
            {{ $currentMonth->format('F Y') }}
        </h2>
        <div class="flex space-x-2">
            <button wire:click="previousMonth" class="p-1 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
            </button>
            <button wire:click="nextMonth" class="p-1 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-7 gap-1 text-center">
        <!-- Days Header -->
        @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
            <div class="text-xs font-medium text-gray-500 dark:text-gray-400 py-1 ps-4 ">{{ $day }}</div>
        @endforeach

        <!-- Dates -->
        @for($date = $startDay->copy(); $date <= $endDay; $date->addDay())
            <div class="py-1 ps-3">
                <div class="text-sm h-8 w-8 flex items-center justify-center rounded-full
                    {{ $date->month != $currentMonth->month ? 'text-gray-300 dark:text-gray-600' : 
                        ($date->isToday() ? 'bg-blue-500 text-white font-medium' : 
                        'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700') }}">
                    {{ $date->format('j') }}
                </div>
            </div>
        @endfor
    </div>
</div>
