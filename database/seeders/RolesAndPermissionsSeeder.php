<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'manage_dashboard',
            'manage_tours',
            'manage_destinations',
            'manage_vehicles',
            'manage_drivers',
            'manage_blogs',
            'manage_categories',
            'manage_exclusions',
            'manage_meals',
            'manage_enquiries',
            'manage_leads',
            'manage_hotels',
            'manage_activities',
            'manage_travel_guides',
            'manage_inclusions',
            'manage_exclusions',
            'manage_faqs',
            'manage_settings',
            'manage_roles',
            'manage_users'
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission]);
        }

        // Create Administrator role and assign all permissions
        $role = Role::updateOrCreate(['name' => 'Administrator']);
        $role->givePermissionTo(Permission::all());

        // Assign Administrator role to the first user
        $user = User::first();
        if ($user) {
            $user->assignRole('Administrator');
        }
    }
}
