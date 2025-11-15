<?php

namespace App\Livewire\Meetings;

use App\Models\Meeting;
use App\Models\Contact;
use App\Models\User;
use Livewire\Component;

class MeetingForm extends Component
{
    public $meetingId;
    public $contactId;
    public $title;
    public $description;
    public $start_time;
    public $end_time;
    public $location;
    public $meeting_type = 'in_person';
    public $meeting_link;
    public $priority = 'medium';

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'start_time' => 'required|date',
        'end_time' => 'required|date|after:start_time',
        'location' => 'nullable|string|max:255',
        'meeting_type' => 'required|in:in_person,online,phone',
        'meeting_link' => 'nullable|url',
        'priority' => 'required|in:low,medium,high',
    ];

    public function mount($meetingId = null, $contactId = null, $date = null)
    {
        $this->contactId = $contactId;

        if ($meetingId) {
            $meeting = Meeting::findOrFail($meetingId);
            $this->fill($meeting->toArray());
        } elseif ($date) {
            $this->start_time = $date . ' 09:00';
            $this->end_time = $date . ' 10:00';
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'location' => $this->location,
            'meeting_type' => $this->meeting_type,
            'meeting_link' => $this->meeting_link,
            'priority' => $this->priority,
            'contact_id' => $this->contactId,
            'owner_id' => auth()->id(),
        ];

        if ($this->meetingId) {
            Meeting::find($this->meetingId)->update($data);
            session()->flash('success', 'Toplantı güncellendi.');
        } else {
            Meeting::create($data);
            session()->flash('success', 'Toplantı oluşturuldu.');
        }

        $this->dispatch('meetingSaved');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.meetings.meeting-form');
    }
}
