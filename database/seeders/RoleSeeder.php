<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::factory()->create([
            'name' => 'Admin'
        ]);
        $editor = Role::factory()->create([
            'name' => 'Editor'
        ]);
        $viewer = Role::factory()->create([
            'name' => 'Viewer'
        ]);

        $permissions = Permission::all(); // Get all permissions.

        // A way to attach all permissions to the admin role.
        /*foreach ($permissions as $permission) {
            \DB::table('role_permissions')->insert([
                'permission_id' => $permission->id
                'role_id' => $admin->id,
            ]);
        }*/

        // Another way to attach all permissions to the admin role.
        $admin->permissions()->attach($permissions->pluck('id')); // Attach all permissions to the admin role.

        $editor->permissions()->attach($permissions->pluck('id'));
        $editor->permissions()->detach(4); // Remove the edit_roles permission from the editor role.

        $viewer->permissions()->attach([1, 3, 5, 7]); // Attach only the view permissions to the viewer role.
    }
}
