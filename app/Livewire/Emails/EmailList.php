<?php

namespace App\Livewire\Emails;

use App\Models\Email;
use Livewire\Component;
use Livewire\WithPagination;

class EmailList extends Component
{
    use WithPagination;

    public $folder = 'inbox'; // inbox, sent, starred, archived
    public $search = '';
    public $selectedEmails = [];
    public $selectAll = false;

    // Sorting
    public $sortBy = 'sent_at';
    public $sortDirection = 'desc';

    protected $queryString = ['folder'];

    /**
     * Reset pagination when search changes
     */
    public function updatedSearch()
    {
        $this->resetPage();
    }

    /**
     * Change folder
     */
    public function changeFolder($folder)
    {
        $this->folder = $folder;
        $this->selectedEmails = [];
        $this->selectAll = false;
        $this->resetPage();
    }

    /**
     * Toggle email selection
     */
    public function toggleSelect($emailId)
    {
        if (in_array($emailId, $this->selectedEmails)) {
            $this->selectedEmails = array_diff($this->selectedEmails, [$emailId]);
        } else {
            $this->selectedEmails[] = $emailId;
        }
    }

    /**
     * Toggle star on email
     */
    public function toggleStar($emailId)
    {
        $email = Email::find($emailId);
        if ($email) {
            $email->toggleStar();
        }
    }

    /**
     * Archive selected emails
     */
    public function archiveSelected()
    {
        Email::whereIn('id', $this->selectedEmails)->update(['is_archived' => true]);
        $this->selectedEmails = [];
        $this->selectAll = false;
        session()->flash('success', 'Emails archived successfully');
    }

    /**
     * Delete selected emails
     */
    public function deleteSelected()
    {
        Email::whereIn('id', $this->selectedEmails)->delete();
        $this->selectedEmails = [];
        $this->selectAll = false;
        session()->flash('success', 'Emails deleted successfully');
    }

    /**
     * Mark selected as read
     */
    public function markAsRead()
    {
        Email::whereIn('id', $this->selectedEmails)->update([
            'is_read' => true,
            'read_at' => now()
        ]);
        $this->selectedEmails = [];
        session()->flash('success', 'Emails marked as read');
    }

    public function render()
    {
        $query = Email::query()
            ->where('team_id', auth()->user()->team_id);

        // Apply folder filter
        switch ($this->folder) {
            case 'inbox':
                $query->where('type', 'inbox')->where('is_archived', false);
                break;
            case 'sent':
                $query->where('type', 'sent');
                break;
            case 'starred':
                $query->where('is_starred', true)->where('is_archived', false);
                break;
            case 'archived':
                $query->where('is_archived', true);
                break;
        }

        // Apply search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('subject', 'like', "%{$this->search}%")
                    ->orWhere('body_html', 'like', "%{$this->search}%")
                    ->orWhere('body_text', 'like', "%{$this->search}%")
                    ->orWhere('from_email', 'like', "%{$this->search}%");
            });
        }

        // Apply sorting
        $query->orderBy($this->sortBy, $this->sortDirection);

        $emails = $query->paginate(20);

        // Calculate stats
        $stats = [
            'inbox' => Email::where('team_id', auth()->user()->team_id)
                ->where('type', 'inbox')
                ->where('is_archived', false)
                ->count(),
            'unread' => Email::where('team_id', auth()->user()->team_id)
                ->where('is_read', false)
                ->where('type', 'inbox')
                ->count(),
            'starred' => Email::where('team_id', auth()->user()->team_id)
                ->where('is_starred', true)
                ->count(),
        ];

        return view('livewire.emails.email-list', [
            'emails' => $emails,
            'stats' => $stats,
        ]);
    }
}
