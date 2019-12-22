<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class first_role_registerSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create(['name' => 'サイト管理者', 'guard_name' => 'admin']);
        $role->givePermissionTo('all_allow');

      /*$role = Role::create(['name' => '～担当', 'guard_name' => 'admin']);
        $permissions = [
            'menu_～ ...etc'
        ];
        $role->givePermissionTo($permissions);*/
    }
}