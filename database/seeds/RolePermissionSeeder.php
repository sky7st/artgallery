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
        $permissionAddWork = Permission::create([
            'name' => 'add new work'
        ]);
        $permissionDeleteWork = Permission::create([
            'name' => 'delete work'
        ]);
        $permissionCustomerUpdate = Permission::create([
            'name' => 'update customer data'
        ]);
        $permissionCustomerBuy = Permission::create([
            'name' => 'buy works'
        ]);
        $permissionEnquiry = Permission::create([
            'name' => 'send enquiry'
        ]);
        $permissionOwnerUpdate = Permission::create([
            'name' => 'update owner data'
        ]);
        $permissionSalerUpdate = Permission::create([
            'name' => 'update saler data'
        ]);
        $permissionMakeTrade = Permission::create([
            'name' => 'make trade'
        ]);
        $permissionTradeConfirm = Permission::create([
            'name' => 'confirm trade'
        ]);
        $permissionCanBeReg = Permission::create([
            'name' => 'can be registered'
        ]);
        
        $permissionViewSelfEnquiry = Permission::create([
            'name' => 'view self enquiry'
        ]);
        
        $permissionViewAllEnquiry = Permission::create([
            'name' => 'view all enquiry'
        ]);

        $permissionViewSalerReport = Permission::create([
            'name' => 'view saler report'
        ]);

        $roleAdmin->syncPermissions([
            $permissionArtistUpdate,
            $permissionCustomerUpdate,
            $permissionOwnerUpdate,
            $permissionSalerUpdate,
            $permissionViewAllEnquiry,
            $permissionMakeTrade,
            $permissionEnquiry,
            $permissionViewSalerReport
        ]);
        
        $roleArtist->syncPermissions([
            $permissionArtistUpdate,
            $permissionAddWork,
            $permissionDeleteWork,
            $permissionTradeConfirm,
            $permissionCanBeReg
        ]);
        $roleCustomer->syncPermissions([
            $permissionCustomerUpdate,
            $permissionCustomerBuy,
            $permissionEnquiry,
            $permissionViewSelfEnquiry,
            $permissionTradeConfirm,
            $permissionCanBeReg
        ]);
        $roleOwner->syncPermissions([
            $permissionOwnerUpdate,
            // $permissionCanBeReg
        ]);
        $roleSaler->syncPermissions([
            $permissionSalerUpdate,
            $permissionViewAllEnquiry,
            $permissionMakeTrade,
            $permissionEnquiry
        ]);

    }
}
