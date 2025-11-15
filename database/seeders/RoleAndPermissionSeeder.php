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
            // Contact permissions
            'view_contacts',
            'create_contacts',
            'edit_contacts',
            'delete_contacts',
            'export_contacts',
            'import_contacts',
            
            // Account permissions
            'view_accounts',
            'create_accounts',
            'edit_accounts',
            'delete_accounts',
            'export_accounts',
            
            // Lead permissions
            'view_leads',
            'create_leads',
            'edit_leads',
            'delete_leads',
            'convert_leads',
            'export_leads',
            'import_leads',
            
            // Opportunity permissions
            'view_opportunities',
            'create_opportunities',
            'edit_opportunities',
            'delete_opportunities',
            'export_opportunities',
            
            // Activity permissions
            'view_activities',
            'create_activities',
            'edit_activities',
            'delete_activities',
            
            // Task permissions
            'view_tasks',
            'create_tasks',
            'edit_tasks',
            'delete_tasks',
            
            // Report permissions
            'view_reports',
            'create_reports',
            'export_reports',
            
            // Settings permissions
            'manage_settings',
            'manage_users',
            'manage_teams',
            'manage_integrations',
            'manage_custom_fields',
            
            // Advanced permissions
            'view_analytics',
            'manage_webhooks',
            'access_api',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        
        // Super Admin - has all permissions
        $superAdmin = Role::create(['name' => 'Super Admin']);
        $superAdmin->givePermissionTo(Permission::all());

        // Admin - has most permissions
        $admin = Role::create(['name' => 'Admin']);
        $admin->givePermissionTo([
            'view_contacts', 'create_contacts', 'edit_contacts', 'delete_contacts', 'export_contacts', 'import_contacts',
            'view_accounts', 'create_accounts', 'edit_accounts', 'delete_accounts', 'export_accounts',
            'view_leads', 'create_leads', 'edit_leads', 'delete_leads', 'convert_leads', 'export_leads', 'import_leads',
            'view_opportunities', 'create_opportunities', 'edit_opportunities', 'delete_opportunities', 'export_opportunities',
            'view_activities', 'create_activities', 'edit_activities', 'delete_activities',
            'view_tasks', 'create_tasks', 'edit_tasks', 'delete_tasks',
            'view_reports', 'create_reports', 'export_reports',
            'manage_custom_fields',
            'view_analytics',
        ]);

        // Sales Manager - can manage sales items
        $salesManager = Role::create(['name' => 'Sales Manager']);
        $salesManager->givePermissionTo([
            'view_contacts', 'create_contacts', 'edit_contacts', 'export_contacts',
            'view_accounts', 'create_accounts', 'edit_accounts', 'export_accounts',
            'view_leads', 'create_leads', 'edit_leads', 'convert_leads', 'export_leads',
            'view_opportunities', 'create_opportunities', 'edit_opportunities', 'export_opportunities',
            'view_activities', 'create_activities', 'edit_activities',
            'view_tasks', 'create_tasks', 'edit_tasks',
            'view_reports', 'export_reports',
            'view_analytics',
        ]);

        // Sales Representative - basic sales permissions
        $salesRep = Role::create(['name' => 'Sales Representative']);
        $salesRep->givePermissionTo([
            'view_contacts', 'create_contacts', 'edit_contacts',
            'view_accounts', 'create_accounts', 'edit_accounts',
            'view_leads', 'create_leads', 'edit_leads', 'convert_leads',
            'view_opportunities', 'create_opportunities', 'edit_opportunities',
            'view_activities', 'create_activities', 'edit_activities',
            'view_tasks', 'create_tasks', 'edit_tasks',
            'view_reports',
        ]);

        // Marketing - focused on leads and campaigns
        $marketing = Role::create(['name' => 'Marketing']);
        $marketing->givePermissionTo([
            'view_contacts', 'export_contacts',
            'view_accounts',
            'view_leads', 'create_leads', 'edit_leads', 'export_leads', 'import_leads',
            'view_activities', 'create_activities',
            'view_reports', 'create_reports',
        ]);

        // Viewer - read-only access
        $viewer = Role::create(['name' => 'Viewer']);
        $viewer->givePermissionTo([
            'view_contacts',
            'view_accounts',
            'view_leads',
            'view_opportunities',
            'view_activities',
            'view_tasks',
            'view_reports',
        ]);

        $this->command->info('Roles and permissions created successfully!');
    }
}