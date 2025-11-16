<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class TenantRegistrationController extends Controller
{
    /**
     * Show tenant registration form
     */
    public function show()
    {
        return view('central.register', [
            'plans' => $this->getPlans(),
        ]);
    }

    /**
     * Store new tenant registration
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:tenants,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'plan' => ['required', 'in:trial,starter,professional,enterprise'],
        ]);

        DB::beginTransaction();

        try {
            // Generate unique tenant ID and slug
            $slug = Str::slug($validated['company_name']);
            $tenantId = $slug . '-' . Str::random(6);

            // Get plan limits
            $planLimits = Tenant::getPlanLimits($validated['plan']);

            // Create tenant
            $tenant = Tenant::create([
                'id' => $tenantId,
                'name' => $validated['company_name'],
                'slug' => $slug,
                'email' => $validated['email'],
                'schema_name' => 'tenant_' . $tenantId,
                'owner_name' => $validated['name'],
                'owner_email' => $validated['email'],
                'plan' => $validated['plan'],
                'status' => 'active',
                'trial_ends_at' => $validated['plan'] === 'trial' ? now()->addDays(14) : null,
                'subscribed_at' => $validated['plan'] !== 'trial' ? now() : null,
                'max_users' => $planLimits['max_users'],
                'max_contacts' => $planLimits['max_contacts'],
                'max_storage_mb' => $planLimits['max_storage_mb'],
                'features' => $planLimits['features'],
                'settings' => [
                    'timezone' => 'UTC',
                    'date_format' => 'Y-m-d',
                    'time_format' => 'H:i',
                ],
            ]);

            // Create tenant subdomain
            $domain = $tenantId . '.' . config('app.domain', 'localhost');
            $tenant->domains()->create([
                'domain' => $domain,
            ]);

            // Initialize tenant database/schema
            // This will automatically create the PostgreSQL schema
            // and run tenant migrations

            // Create owner user in tenant context
            $tenant->run(function () use ($validated) {
                // Create owner user
                \App\Models\User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                    'email_verified_at' => now(),
                    'is_owner' => true,
                ]);

                // Create default team
                \App\Models\Team::create([
                    'name' => 'Default Team',
                    'slug' => 'default',
                ]);
            });

            // Create subscription record if not trial
            if ($validated['plan'] !== 'trial') {
                $tenant->subscriptions()->create([
                    'plan' => $validated['plan'],
                    'status' => 'active',
                    'amount' => $this->getPlanAmount($validated['plan']),
                    'currency' => 'USD',
                    'billing_period' => 'monthly',
                    'next_billing_date' => now()->addMonth(),
                ]);
            }

            DB::commit();

            // Send welcome email (optional)
            // Mail::to($tenant->email)->send(new WelcomeEmail($tenant));

            // Redirect to tenant domain
            return redirect()
                ->away('http://' . $domain . '/login')
                ->with('success', 'Your account has been created! Please login to continue.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->withErrors(['error' => 'Failed to create account: ' . $e->getMessage()]);
        }
    }

    /**
     * Get available plans
     */
    private function getPlans(): array
    {
        return [
            'trial' => [
                'name' => 'Trial',
                'price' => 0,
                'period' => '14 days',
                'features' => [
                    '3 users',
                    '100 contacts',
                    '500 MB storage',
                    'Basic CRM features',
                ],
            ],
            'starter' => [
                'name' => 'Starter',
                'price' => 29,
                'period' => 'month',
                'features' => [
                    '5 users',
                    '1,000 contacts',
                    '2 GB storage',
                    'Email integration',
                    'Custom fields',
                ],
            ],
            'professional' => [
                'name' => 'Professional',
                'price' => 79,
                'period' => 'month',
                'features' => [
                    '25 users',
                    '10,000 contacts',
                    '10 GB storage',
                    'Advanced reports',
                    'API access',
                    'Priority support',
                ],
            ],
            'enterprise' => [
                'name' => 'Enterprise',
                'price' => 199,
                'period' => 'month',
                'features' => [
                    '100 users',
                    '50,000 contacts',
                    '50 GB storage',
                    'White label',
                    'Dedicated support',
                    'Custom integrations',
                ],
            ],
        ];
    }

    /**
     * Get plan amount
     */
    private function getPlanAmount(string $plan): float
    {
        return match($plan) {
            'starter' => 29.00,
            'professional' => 79.00,
            'enterprise' => 199.00,
            default => 0.00,
        };
    }
}
