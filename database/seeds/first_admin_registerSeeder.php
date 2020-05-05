<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Model\Admin;
use Carbon\Carbon;
use App\Library\OpenSslCryptor;

class first_admin_registerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        $obj = new OpenSslCryptor('bf-cbc');

        $names = ['広重', '森野'];
        $user_ids = ['brightgb', 'imai2gou'];
        $passwords = ['supadesu21', 'imai2gou'];
        for ($i=0; $i<=1; $i++) {
            DB::table('admins')->insert([
                'name'         => $names[$i],
                'userid'       => $user_ids[$i],
                'password'     => bcrypt($passwords[$i]),
                'password_org' => $obj->encrypt($passwords[$i]),
                'created_at'   => $now,
                'updated_at'   => $now
            ]);
            $admin = Admin::findOrFail($i+1);
            $admin->assignRole('サイト管理者');
        }

        $count = 1;
        for ($i=10; $i>=1; $i--) {
            DB::table('admin_infos')->insert([
                'notify_type' => mt_rand(1, 2),
                'notify_date' => Carbon::now()->subDay($i),
                'message'     => 'お知らせテスト'.$count,
                'created_at'  => $now,
                'updated_at'  => $now
            ]);
            $count++;
        }
    }
}