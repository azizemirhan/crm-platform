<?php

namespace App\Livewire\Accounts;

use App\Models\Account;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class AccountList extends Component
{
    use WithPagination;

    // Filters
    public $search = '';
    public $filters = [
        'industry' => '',
        'type' => '',
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
            'industry' => '',
            'type' => '',
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
        $query = Account::with(['owner'])
            ->when($this->search, function ($q) {
                $q->where(function ($sq) {
                    $sq->where('name', 'like', "%{$this->search}%")
                        ->orWhere('legal_name', 'like', "%{$this->search}%")
                        ->orWhere('email', 'like', "%{$this->search}%")
                        ->orWhere('phone', 'like', "%{$this->search}%");
                });
            })
            ->when($this->filters['industry'], function ($q) {
                $q->where('industry', $this->filters['industry']);
            })
            ->when($this->filters['type'], function ($q) {
                $q->where('type', $this->filters['type']);
            })
            ->when($this->filters['owner_id'], function ($q) {
                $q->where('owner_id', $this->filters['owner_id']);
            });

        // Apply sorting
        $query->orderBy($this->sortBy, $this->sortDirection);

        $accounts = $query->paginate(15);

        // Calculate stats
        $stats = [
            'total' => Account::count(),
            'active' => Account::whereNotNull('annual_revenue')->count(),
            'this_month' => Account::whereMonth('created_at', now()->month)->count(),
        ];

        // Get data for filters
        $users = User::orderBy('name')->get();

        return view('livewire.accounts.account-list', [
            'accounts' => $accounts,
            'stats' => $stats,
            'users' => $users,
        ]);
    }
}
