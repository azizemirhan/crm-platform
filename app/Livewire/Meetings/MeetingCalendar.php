<?php

namespace App\Livewire\Meetings;

use App\Models\Meeting;
use Livewire\Component;

class MeetingCalendar extends Component
{
    public $contactId;
    public $currentMonth;
    public $currentYear;
    public $selectedDate;

    public function mount($contactId = null)
    {
        $this->contactId = $contactId;
        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;
    }

    public function previousMonth()
    {
        if ($this->currentMonth == 1) {
            $this->currentMonth = 12;
            $this->currentYear--;
        } else {
            $this->currentMonth--;
        }
    }

    public function nextMonth()
    {
        if ($this->currentMonth == 12) {
            $this->currentMonth = 1;
            $this->currentYear++;
        } else {
            $this->currentMonth++;
        }
    }

    public function selectDate($date)
    {
        $this->selectedDate = $date;
        $this->dispatch('openMeetingModal', date: $date, contactId: $this->contactId);
    }

    public function render()
    {
        $query = Meeting::whereYear('start_time', $this->currentYear)
            ->whereMonth('start_time', $this->currentMonth);

        if ($this->contactId) {
            $query->where('contact_id', $this->contactId);
        }

        $meetings = $query->get();

        return view('livewire.meetings.meeting-calendar', [
            'meetings' => $meetings,
        ]);
    }
}
