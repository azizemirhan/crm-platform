<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Contacts
            'contacts.view',
            'contacts.view_all',
            'contacts.create',
            'contacts.edit',
            'contacts.delete',
            'contacts.export',
            'contacts.import',
            
            // Accounts
            'accounts.view',
            'accounts.view_all',
            'accounts.create',
            'accounts.edit',
            'accounts.delete',
            
            // Leads
            'leads.view',
            'leads.view_all',
            'leads.create',
            'leads.edit',
            'leads.delete',
            'leads.convert',
            
            // Opportunities
            'opportunities.view',
            'opportunities.view_all',
            'opportunities.create',
            'opportunities.edit',
            'opportunities.delete',
            
            // Activities
            'activities.view',
            'activities.view_all',
            'activities.create',
            'activities.edit',
            'activities.delete',
            
            // Tasks
            'tasks.view',
            'tasks.view_all',
            'tasks.create',
            'tasks.edit',
            'tasks.delete',
            'tasks.assign',
            
            // Reports
            'reports.view',
            'reports.view_all_teams',
            'reports.export',
            
            // Settings
            'settings.view',
            'settings.edit',
            'settings.manage_users',
            'settings.manage_roles',
            'settings.manage_custom_fields',
            'settings.manage_integrations',
            'settings.manage_billing',
            
            // Marketing
            'marketing.campaigns.view',
            'marketing.campaigns.create',
            'marketing.campaigns.edit',
            'marketing.campaigns.delete',
            'marketing.campaigns.send',
            
            // Lists
            'lists.view',
            'lists.create',
            'lists.edit',
            'lists.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles
        $admin = Role::create(['name' => 'admin']);
        $salesManager = Role::create(['name' => 'sales_manager']);
        $salesRep = Role::create(['name' => 'sales_rep']);
        $marketing = Role::create(['name' => 'marketing']);
        $readonly = Role::create(['name' => 'readonly']);

        // Admin - Full access
        $admin->givePermissionTo(Permission::all());

        // Sales Manager
        $salesManager->givePermissionTo([
            'contacts.view_all',
            'contacts.create',
            'contacts.edit',
            'contacts.delete',
            'contacts.export',
            'accounts.view_all',
            'accounts.create',
            'accounts.edit',
            'accounts.delete',
            'leads.view_all',
            'leads.create',
            'leads.edit',
            'leads.delete',
            'leads.convert',
            'opportunities.view_all',
            'opportunities.create',
            'opportunities.edit',
            'opportunities.delete',
            'activities.view_all',
            'activities.create',
            'activities.edit',
            'activities.delete',
            'tasks.view_all',
            'tasks.create',
            'tasks.edit',
            'tasks.delete',
            'tasks.assign',
            'reports.view',
            'reports.view_all_teams',
            'reports.export',
        ]);

        // Sales Representative
        $salesRep->givePermissionTo([
            'contacts.view',
            'contacts.create',
            'contacts.edit',
            'accounts.view',
            'accounts.create',
            'accounts.edit',
            'leads.view',
            'leads.create',
            'leads.edit',
            'leads.convert',
            'opportunities.view',
            'opportunities.create',
            'opportunities.edit',
            'activities.view',
            'activities.create',
            'activities.edit',
            'tasks.view',
            'tasks.create',
            'tasks.edit',
            'reports.view',
        ]);

        // Marketing
        $marketing->givePermissionTo([
            'contacts.view_all',
            'contacts.export',
            'contacts.import',
            'leads.view_all',
            'leads.create',
            'leads.edit',
            'marketing.campaigns.view',
            'marketing.campaigns.create',
            'marketing.campaigns.edit',
            'marketing.campaigns.send',
            'lists.view',
            'lists.create',
            'lists.edit',
            'reports.view',
        ]);

        // Read-only
        $readonly->givePermissionTo([
            'contacts.view',
            'accounts.view',
            'leads.view',
            'opportunities.view',
            'activities.view',
            'tasks.view',
            'reports.view',
        ]);
    }
}