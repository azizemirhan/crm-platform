<?php

namespace App\Livewire\Opportunities;

use App\Models\Opportunity;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class OpportunityList extends Component
{
    use WithPagination;

    public $search = '';
    public $filters = [
        'stage' => '',
        'owner_id' => '',
    ];
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    public function updatedSearch() { $this->resetPage(); }
    public function updatedFilters() { $this->resetPage(); }

    public function clearFilters()
    {
        $this->search = '';
        $this->filters = ['stage' => '', 'owner_id' => ''];
        $this->resetPage();
    }

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
        $query = Opportunity::with(['owner', 'account', 'contact'])
            ->when($this->search, function ($q) {
                $q->where('name', 'like', "%{$this->search}%");
            })
            ->when($this->filters['stage'], fn($q) => $q->where('stage', $this->filters['stage']))
            ->when($this->filters['owner_id'], fn($q) => $q->where('owner_id', $this->filters['owner_id']));

        $query->orderBy($this->sortBy, $this->sortDirection);
        $opportunities = $query->paginate(15);

        $stats = [
            'total' => Opportunity::count(),
            'open' => Opportunity::whereNotIn('stage', ['closed_won', 'closed_lost'])->count(),
            'won' => Opportunity::where('stage', 'closed_won')->count(),
            'total_value' => Opportunity::whereNotIn('stage', ['closed_won', 'closed_lost'])->sum('amount'),
        ];

        $users = User::orderBy('name')->get();

        return view('livewire.opportunities.opportunity-list', compact('opportunities', 'stats', 'users'));
    }
}
