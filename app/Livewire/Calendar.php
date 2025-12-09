<?php

namespace App\Livewire;

use Livewire\Component;
use Carbon\Carbon;

class Calendar extends Component
{
    public $currentMonth;

    public function mount()
    {
        $this->currentMonth = Carbon::now()->startOfMonth();
    }

    public function previousMonth()
    {
        $this->currentMonth = $this->currentMonth->copy()->subMonth();
    }

    public function nextMonth()
    {
        $this->currentMonth = $this->currentMonth->copy()->addMonth();
    }

    public function render()
    {
        $firstDay = $this->currentMonth->copy()->startOfMonth();
        $lastDay = $this->currentMonth->copy()->endOfMonth();
        $startDay = $firstDay->copy()->startOfWeek(Carbon::SUNDAY);
        $endDay = $lastDay->copy()->endOfWeek(Carbon::SATURDAY);

        return view('livewire.calendar', [
            'firstDay' => $firstDay,
            'lastDay' => $lastDay,
            'startDay' => $startDay,
            'endDay' => $endDay,
        ]);
    }
}