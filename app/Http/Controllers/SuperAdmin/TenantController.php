<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    /**
     * Display a listing of tenants
     */
    public function index(Request $request)
    {
        $query = Tenant::with('domains', 'activeSubscription');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by plan
        if ($request->filled('plan')) {
            $query->where('plan', $request->plan);
        }

        $tenants = $query->latest()->paginate(20);

        return view('super-admin.tenants.index', compact('tenants'));
    }

    /**
     * Display the specified tenant
     */
    public function show(Tenant $tenant)
    {
        $tenant->load(['domains', 'subscriptions', 'activeSubscription']);

        // Get tenant usage stats
        $usage = [
            'users' => $tenant->current_users,
            'contacts' => $tenant->current_contacts,
            'storage' => $tenant->current_storage_mb,
        ];

        // Get Telescope entries for this tenant
        $telescopeEntries = [];
        if (class_exists('\Laravel\Telescope\EntryModel')) {
            $telescopeEntries = \Laravel\Telescope\EntryModel::where('content->tenant_id', $tenant->id)
                ->orWhere('content->hostname', 'like', "%{$tenant->id}%")
                ->latest()
                ->limit(50)
                ->get();
        }

        // Get recent activity logs
        $activityLogs = [];
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('activity_log')) {
                $activityLogs = \Illuminate\Support\Facades\DB::table('activity_log')
                    ->where('log_name', $tenant->id)
                    ->orWhere('subject_type', 'like', "%{$tenant->id}%")
                    ->latest('created_at')
                    ->limit(100)
                    ->get();
            }
        } catch (\Exception $e) {
            // If activity log is not available, continue without it
            $activityLogs = [];
        }

        // Calculate Telescope stats
        $telescopeStats = [
            'total_requests' => 0,
            'total_exceptions' => 0,
            'total_queries' => 0,
            'avg_response_time' => 0,
        ];

        if (class_exists('\Laravel\Telescope\EntryModel')) {
            $telescopeStats['total_requests'] = \Laravel\Telescope\EntryModel::where('type', 'request')
                ->where('content->tenant_id', $tenant->id)
                ->count();

            $telescopeStats['total_exceptions'] = \Laravel\Telescope\EntryModel::where('type', 'exception')
                ->where('content->tenant_id', $tenant->id)
                ->count();

            $telescopeStats['total_queries'] = \Laravel\Telescope\EntryModel::where('type', 'query')
                ->where('content->tenant_id', $tenant->id)
                ->count();

            $avgTime = \Laravel\Telescope\EntryModel::where('type', 'request')
                ->where('content->tenant_id', $tenant->id)
                ->avg('content->duration');

            $telescopeStats['avg_response_time'] = round($avgTime ?? 0, 2);
        }

        return view('super-admin.tenants.show', compact('tenant', 'usage', 'telescopeEntries', 'activityLogs', 'telescopeStats'));
    }

    /**
     * Suspend tenant
     */
    public function suspend(Request $request, Tenant $tenant)
    {
        $request->validate([
            'reason' => ['nullable', 'string', 'max:500'],
        ]);

        $tenant->suspend($request->reason);

        return back()->with('success', 'Tenant has been suspended.');
    }

    /**
     * Activate tenant
     */
    public function activate(Tenant $tenant)
    {
        $tenant->activate();

        return back()->with('success', 'Tenant has been activated.');
    }

    /**
     * Cancel tenant subscription
     */
    public function cancelSubscription(Tenant $tenant)
    {
        $subscription = $tenant->activeSubscription;

        if ($subscription) {
            $subscription->cancel();
            return back()->with('success', 'Subscription has been cancelled.');
        }

        return back()->withErrors(['error' => 'No active subscription found.']);
    }

    /**
     * Get tenant usage statistics
     */
    public function usage(Tenant $tenant)
    {
        $stats = $tenant->run(function () {
            return [
                'users' => \App\Models\User::count(),
                'contacts' => \App\Models\Contact::count(),
                'leads' => \App\Models\Lead::count(),
                'opportunities' => \App\Models\Opportunity::count(),
                'accounts' => \App\Models\Account::count(),
            ];
        });

        return response()->json($stats);
    }
}
