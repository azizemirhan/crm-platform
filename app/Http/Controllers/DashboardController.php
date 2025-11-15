<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Contact;
use App\Models\Lead;
use App\Models\Opportunity;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        // Stats
        $stats = $this->getStats($user);
        
        // Recent activities
        $recentActivities = $this->getRecentActivities($user);
        
        // Upcoming tasks
        $upcomingTasks = $this->getUpcomingTasks($user);
        
        // Sales pipeline
        $pipeline = $this->getSalesPipeline($user);
        
        // Lead sources chart data
        $leadSources = $this->getLeadSourcesData($user);
        
        return view('dashboard', compact(
            'stats',
            'recentActivities',
            'upcomingTasks',
            'pipeline',
            'leadSources'
        ));
    }

    private function getStats($user): array
    {
        $contactsQuery = Contact::query();
        $leadsQuery = Lead::query();
        $opportunitiesQuery = Opportunity::query();
        
        // Apply visibility rules
        if (!$user->hasRole(['admin', 'sales_manager'])) {
            $contactsQuery->where('owner_id', $user->id);
            $leadsQuery->where('owner_id', $user->id);
            $opportunitiesQuery->where('owner_id', $user->id);
        }

        return [
            'total_contacts' => $contactsQuery->active()->count(),
            'total_leads' => $leadsQuery->whereIn('status', ['new', 'contacted', 'qualified'])->count(),
            'open_opportunities' => $opportunitiesQuery->open()->count(),
            'open_opportunities_value' => $opportunitiesQuery->open()->sum('amount'),
            'won_this_month' => $opportunitiesQuery
                ->where('stage', 'closed_won')
                ->whereMonth('actual_close_date', now()->month)
                ->sum('amount'),
            'tasks_due_today' => Task::where('assigned_to_id', $user->id)->dueToday()->count(),
            'overdue_tasks' => Task::where('assigned_to_id', $user->id)->overdue()->count(),
        ];
    }

    private function getRecentActivities($user, int $limit = 10)
    {
        $query = \App\Models\Activity::with(['user', 'subject'])
            ->orderBy('created_at', 'desc')
            ->limit($limit);

        if (!$user->hasRole(['admin', 'sales_manager'])) {
            $query->where('user_id', $user->id);
        }

        return $query->get();
    }

    private function getUpcomingTasks($user, int $limit = 10)
    {
        return Task::with(['taskable', 'assignedUser']) // <-- 2. BURAYI DEĞİŞTİRİN
            ->assignedTo($user) // Bu satır artık scopeAssignedTo'yu doğru çağıracak
            ->pending()
            ->whereNotNull('due_date')
            ->orderBy('due_date')
            ->limit($limit)
            ->get();
    }

    private function getSalesPipeline($user): array
    {
        $query = Opportunity::open();

        if (!$user->hasRole(['admin', 'sales_manager'])) {
            $query->where('owner_id', $user->id);
        }

        $opportunities = $query->get();

        $pipeline = [];
        foreach (Opportunity::$stages as $stage => $config) {
            if (in_array($stage, ['closed_won', 'closed_lost'])) {
                continue;
            }

            $stageOpportunities = $opportunities->where('stage', $stage);
            
            $pipeline[] = [
                'stage' => $stage,
                'label' => $config['label'],
                'count' => $stageOpportunities->count(),
                'total_value' => $stageOpportunities->sum('amount'),
                'weighted_value' => $stageOpportunities->sum('weighted_amount'),
            ];
        }

        return $pipeline;
    }

    private function getLeadSourcesData($user): array
    {
        $query = Lead::select('source', DB::raw('count(*) as count'))
            ->groupBy('source');

        if (!$user->hasRole(['admin', 'sales_manager'])) {
            $query->where('owner_id', $user->id);
        }

        return $query->get()
            ->map(fn($item) => [
                'source' => $item->source,
                'count' => $item->count,
            ])
            ->toArray();
    }
}