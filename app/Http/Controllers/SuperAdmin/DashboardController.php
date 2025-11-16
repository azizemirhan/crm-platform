<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\Subscription;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show super admin dashboard
     */
    public function index()
    {
        $stats = [
            'total_tenants' => Tenant::count(),
            'active_tenants' => Tenant::where('status', 'active')->count(),
            'trial_tenants' => Tenant::where('plan', 'trial')->count(),
            'suspended_tenants' => Tenant::where('status', 'suspended')->count(),
            'total_revenue' => Subscription::where('status', 'active')->sum('amount'),
            'new_tenants_this_month' => Tenant::whereMonth('created_at', now()->month)->count(),
        ];

        $recentTenants = Tenant::latest()
            ->with('domains')
            ->limit(10)
            ->get();

        $expiringTrials = Tenant::where('plan', 'trial')
            ->where('trial_ends_at', '<=', now()->addDays(7))
            ->where('trial_ends_at', '>=', now())
            ->with('domains')
            ->get();

        return view('super-admin.dashboard', compact('stats', 'recentTenants', 'expiringTrials'));
    }
}
