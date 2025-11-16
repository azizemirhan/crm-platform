<?php

namespace App\Livewire\Contacts;

use App\Models\Account;
use App\Models\Contact;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ContactList extends Component
{
    use WithPagination;

    // Filters
    public $search = '';
    public $filters = [
        'status' => '',
        'source' => '',
        'account_id' => '',
        'owner_id' => '',
    ];

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

    public function updatedFilters()
    {
        $this->resetPage();
    }

    /**
     * Clear all filters
     */
    public function clearFilters()
    {
        $this->search = '';
        $this->filters = [
            'status' => '',
            'source' => '',
            'account_id' => '',
            'owner_id' => '',
        ];
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
            ->when($this->filters['status'], function ($q) {
                $q->where('status', $this->filters['status']);
            })
            ->when($this->filters['source'], function ($q) {
                $q->where('lead_source', $this->filters['source']);
            })
            ->when($this->filters['account_id'], function ($q) {
                $q->where('account_id', $this->filters['account_id']);
            })
            ->when($this->filters['owner_id'], function ($q) {
                $q->where('owner_id', $this->filters['owner_id']);
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

        // Get data for filters
        $accounts = Account::orderBy('name')->get();
        $users = User::orderBy('name')->get();

        return view('livewire.contacts.contact-list', [
            'contacts' => $contacts,
            'stats' => $stats,
            'accounts' => $accounts,
            'users' => $users,
        ]);
    }
}
