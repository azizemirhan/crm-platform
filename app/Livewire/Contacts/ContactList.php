<?php

namespace App\Livewire\Contacts;

use App\Models\Contact;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ContactList extends Component
{
    use WithPagination;

    // Filters
    public $search = '';
    public $status = '';
    public $source = '';

    // Sorting
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    /**
     * Reset pagination when filters change
     */
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatus()
    {
        $this->resetPage();
    }

    public function updatedSource()
    {
        $this->resetPage();
    }

    /**
     * Clear all filters
     */
    public function clearFilters()
    {
        $this->search = '';
        $this->status = '';
        $this->source = '';
        $this->resetPage();
    }

    /**
     * Sort by column
     */
    public function sortBy($column)
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    public function render()
    {
        $query = Contact::with(['owner', 'account'])
            ->when($this->search, function ($q) {
                $q->where(function ($sq) {
                    $sq->where('first_name', 'like', "%{$this->search}%")
                        ->orWhere('last_name', 'like', "%{$this->search}%")
                        ->orWhere('email', 'like', "%{$this->search}%")
                        ->orWhere('phone', 'like', "%{$this->search}%");
                });
            })
            ->when($this->status, function ($q) {
                $q->where('status', $this->status);
            })
            ->when($this->source, function ($q) {
                $q->where('lead_source', $this->source);
            });

        // Apply sorting
        $query->orderBy($this->sortBy, $this->sortDirection);

        $contacts = $query->paginate(15);

        // Calculate stats
        $stats = [
            'total' => Contact::count(),
            'active' => Contact::where('status', 'active')->count(),
            'high_engagement' => Contact::where('engagement_score', '>=', 70)->count(),
        ];

        return view('livewire.contacts.contact-list', [
            'contacts' => $contacts,
            'stats' => $stats,
        ]);
    }
}
