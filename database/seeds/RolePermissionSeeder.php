<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $role = Role::create([
                'name' => 'artist'
            ]);
            $permission = Permission::create([
                'name' => 'update artist data'
            ]);
            $role->syncPermissions($permission);
        } catch (\Throwable $th) {
            echo $th;
        }
        
    }
}
