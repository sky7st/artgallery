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
        $roleAdmin = Role::create([
            'name' => 'admin'
        ]);
        $roleArtist = Role::create([
            'name' => 'artist'
        ]);
        $roleCustomer = Role::create([
            'name' => 'customer'
        ]);
        $roleOwner = Role::create([
            'name' => 'owner'
        ]);
        $roleSaler = Role::create([
            'name' => 'saler'
        ]);
        $permissionArtistUpdate = Permission::create([
            'name' => 'update artist data'
        ]);
        $permissionCustomerUpdate = Permission::create([
            'name' => 'update customer data'
        ]);
        $permissionOwnerUpdate = Permission::create([
            'name' => 'update owner data'
        ]);
        $permissionSalerUpdate = Permission::create([
            'name' => 'update saler data'
        ]);
        
        $permissionCanBeReg = Permission::create([
            'name' => 'can be registered'
        ]);

        $roleAdmin->syncPermissions([
            $permissionArtistUpdate,
            $permissionCustomerUpdate,
            $permissionOwnerUpdate,
            $permissionSalerUpdate
        ]);
        
        $roleArtist->syncPermissions([
            $permissionArtistUpdate,
            $permissionCanBeReg
        ]);
        $roleCustomer->syncPermissions([
            $permissionCustomerUpdate,
            $permissionCanBeReg
        ]);
        $roleOwner->syncPermissions([
            $permissionOwnerUpdate,
            $permissionCanBeReg
        ]);
        $roleSaler->syncPermissions([
            $permissionSalerUpdate
        ]);

    }
}
