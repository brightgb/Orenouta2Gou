<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class first_permission_registerSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //すべての権限を持っている
        Permission::create(['name' => 'developer', 'guard_name' => 'admin']);
        Permission::create(['name' => 'all_allow', 'guard_name' => 'admin']);

        //パーミッション以外の全ての権限
        /*$list = array(
            //稼働状況管理
            'menu_operation_status',
        );

        foreach($list as $val) {
            if (empty($val)) {
                break;
            }
            Permission::create(['name' => "$val", 'guard_name' => 'admin']);
        }*/
    }
}