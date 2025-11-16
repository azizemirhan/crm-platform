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

    // View mode
    public $viewMode = 'list';
    public $showAdvancedFilters = false;

    // Filters
    public $search = '';
    public $filters = [
        'status' => '',
        'type' => '',
        'source' => '',
        'industry' => '',
        'account_id' => '',
        'owner_id' => '',
    ];

    // Sorting
    public $sortField = 'created_at';
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
    public function resetFilters()
    {
        $this->search = '';
        $this->filters = [
            'status' => '',
            'type' => '',
            'source' => '',
            'industry' => '',
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
        if ($this->sortField === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $column;
            $this->sortDirection = 'asc';
        }
    }

    /**
     * Delete contact
     */
    public function deleteContact($contactId)
    {
        $contact = Contact::findOrFail($contactId);
        $contact->delete();

        session()->flash('success', 'Kişi başarıyla silindi.');
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
            ->when($this->filters['type'], function ($q) {
                $q->where('type', $this->filters['type']);
            })
            ->when($this->filters['source'], function ($q) {
                $q->where('lead_source', $this->filters['source']);
            })
            ->when($this->filters['industry'], function ($q) {
                $q->where('industry', $this->filters['industry']);
            })
            ->when($this->filters['account_id'], function ($q) {
                $q->where('account_id', $this->filters['account_id']);
            })
            ->when($this->filters['owner_id'], function ($q) {
                $q->where('owner_id', $this->filters['owner_id']);
            });

        // Apply sorting
        $query->orderBy($this->sortField, $this->sortDirection);

        $contacts = $query->paginate(15);

        // Calculate stats
        $stats = [
            'total' => Contact::count(),
            'this_month' => Contact::whereMonth('created_at', now()->month)->count(),
            'with_accounts' => Contact::whereNotNull('account_id')->count(),
            'vip' => Contact::where('is_vip', true)->count(),
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
