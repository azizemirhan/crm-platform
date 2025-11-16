<?php

namespace App\Livewire\Calls;

use App\Models\Call;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class CallList extends Component
{
    use WithPagination;

    // Filters
    public $search = '';
    public $filters = [
        'direction' => '', // inbound, outbound
        'status' => '', // completed, failed, busy, no-answer
        'disposition' => '', // answered, busy, no-answer, failed, voicemail
        'user_id' => '',
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
            'direction' => '',
            'status' => '',
            'disposition' => '',
            'user_id' => '',
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
        $query = Call::with(['user', 'related_to'])
            ->where('team_id', auth()->user()->team_id)
            ->when($this->search, function ($q) {
                $q->where(function ($sq) {
                    $sq->where('from_number', 'like', "%{$this->search}%")
                        ->orWhere('to_number', 'like', "%{$this->search}%")
                        ->orWhere('from_name', 'like', "%{$this->search}%")
                        ->orWhere('to_name', 'like', "%{$this->search}%");
                });
            })
            ->when($this->filters['direction'], function ($q) {
                $q->where('direction', $this->filters['direction']);
            })
            ->when($this->filters['status'], function ($q) {
                $q->where('status', $this->filters['status']);
            })
            ->when($this->filters['disposition'], function ($q) {
                $q->where('disposition', $this->filters['disposition']);
            })
            ->when($this->filters['user_id'], function ($q) {
                $q->where('user_id', $this->filters['user_id']);
            });

        // Apply sorting
        $query->orderBy($this->sortBy, $this->sortDirection);

        $calls = $query->paginate(20);

        // Calculate stats
        $stats = [
            'total' => Call::where('team_id', auth()->user()->team_id)->count(),
            'today' => Call::where('team_id', auth()->user()->team_id)
                ->whereDate('created_at', today())
                ->count(),
            'answered' => Call::where('team_id', auth()->user()->team_id)
                ->where('disposition', 'answered')
                ->count(),
            'missed' => Call::where('team_id', auth()->user()->team_id)
                ->where('disposition', 'no-answer')
                ->count(),
            'total_duration' => Call::where('team_id', auth()->user()->team_id)
                ->where('disposition', 'answered')
                ->sum('duration'),
        ];

        // Get data for filters
        $users = User::where('team_id', auth()->user()->team_id)
            ->orderBy('name')
            ->get();

        return view('livewire.calls.call-list', [
            'calls' => $calls,
            'stats' => $stats,
            'users' => $users,
        ]);
    }
}
