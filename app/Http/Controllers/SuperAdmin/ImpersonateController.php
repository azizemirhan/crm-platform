<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImpersonateController extends Controller
{
    /**
     * Start impersonating a tenant
     */
    public function start(Tenant $tenant)
    {
        // Verify super admin is logged in
        if (!Auth::guard('super-admin')->check()) {
            abort(403, 'Unauthorized');
        }

        // Check if tenant is active
        if (!$tenant->isActive()) {
            return back()->withErrors(['error' => 'Cannot impersonate a suspended tenant.']);
        }

        // Store super admin info in session
        session([
            'impersonating_from' => Auth::guard('super-admin')->id(),
            'impersonating_tenant' => $tenant->id,
        ]);

        // Initialize tenancy
        tenancy()->initialize($tenant);

        // Get tenant's owner user
        $tenantOwner = $tenant->run(function () {
            return \App\Models\User::where('is_owner', true)->first();
        });

        if (!$tenantOwner) {
            // If no owner, get first user
            $tenantOwner = $tenant->run(function () {
                return \App\Models\User::first();
            });
        }

        if ($tenantOwner) {
            // Login as tenant user
            Auth::guard('web')->login($tenantOwner);
        }

        // Get tenant domain
        $domain = $tenant->domains->first()?->domain ?? 'localhost';

        // Redirect to tenant dashboard
        return redirect()
            ->away('http://' . $domain . '/dashboard')
            ->with('impersonating', true)
            ->with('info', 'You are now impersonating ' . $tenant->name);
    }

    /**
     * Stop impersonating and return to super admin
     */
    public function leave(Request $request)
    {
        $superAdminId = session('impersonating_from');

        if (!$superAdminId) {
            return redirect()->route('super-admin.login');
        }

        // Logout from tenant
        Auth::guard('web')->logout();

        // Clear impersonation session
        session()->forget(['impersonating_from', 'impersonating_tenant', 'impersonating']);

        // End tenancy
        tenancy()->end();

        // Redirect back to super admin dashboard
        return redirect()
            ->route('super-admin.dashboard')
            ->with('success', 'You have stopped impersonating.');
    }
}
