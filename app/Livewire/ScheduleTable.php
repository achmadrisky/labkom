<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Booking;
use Carbon\Carbon;

class ScheduleTable extends Component
{
    public $weekStart;
    public $weekEnd;
    public $viewMode = 'week'; // default: minggu, bisa 'month'

    public function mount()
    {
        $this->weekStart = Carbon::now()->startOfWeek()->toDateString();
        $this->weekEnd   = Carbon::now()->endOfWeek()->toDateString();
    }

    // Navigasi minggu
public function previousWeek()
{
    $ws = Carbon::parse($this->weekStart)->subWeek();
    $we = Carbon::parse($this->weekEnd)->subWeek();

    $this->weekStart = $ws->toDateString();
    $this->weekEnd   = $we->toDateString();
}

public function nextWeek()
{
    $ws = Carbon::parse($this->weekStart)->addWeek();
    $we = Carbon::parse($this->weekEnd)->addWeek();

    $this->weekStart = $ws->toDateString();
    $this->weekEnd   = $we->toDateString();
}

public function goToCurrentWeek()
{
    $this->weekStart = Carbon::now()->startOfWeek()->toDateString();
    $this->weekEnd   = Carbon::now()->endOfWeek()->toDateString();
}


    // Navigasi bulan
    public function previousMonth()
    {
        $this->weekStart = Carbon::parse($this->weekStart)->subMonth()->startOfMonth()->toDateString();
        $this->weekEnd   = Carbon::parse($this->weekStart)->endOfMonth()->toDateString();
    }

    public function nextMonth()
    {
        $this->weekStart = Carbon::parse($this->weekStart)->addMonth()->startOfMonth()->toDateString();
        $this->weekEnd   = Carbon::parse($this->weekStart)->endOfMonth()->toDateString();
    }

    public function goToCurrentMonth()
    {
        $this->weekStart = Carbon::now()->startOfMonth()->toDateString();
        $this->weekEnd   = Carbon::now()->endOfMonth()->toDateString();
    }

    public function render()
    {
        $start = Carbon::parse($this->weekStart);
        $end   = Carbon::parse($this->weekEnd);

        if ($this->viewMode === 'week') {
            $days = collect(range(0,6))->map(fn($d) => $start->copy()->addDays($d));
        } else {
            $days = collect();
            $current = $start->copy();
            while ($current <= $end) {
                $days->push($current->copy());
                $current->addDay();
            }
        }

        $bookings = Booking::with(['lab','course','user'])
            ->where('status', 'approved')
            ->whereBetween('date', [$this->weekStart, $this->weekEnd])
            ->get();

        return view('livewire.schedule-table', [
            'bookings' => $bookings,
            'days' => $days,
            'start' => $start,
            'end' => $end,
        ]);
    }
}
