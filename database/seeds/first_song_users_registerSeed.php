<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Library\OpenSslCryptor;
use Carbon\Carbon;

class first_song_users_registerSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $obj = new OpenSslCryptor('bf-cbc');
        $now = Carbon::now();

        for ($i=1; $i<=50; $i++) {
            DB::table('song_users')->insert([
                'nickname'     => 'テスト歌手'.$i,
                'userid'       => 'test'.str_pad($i, 2, 0, STR_PAD_LEFT),
                'password'     => bcrypt('testst'),
                'password_org' => $obj->encrypt('testst'),
                'created_at'   => $now,
                'updated_at'   => $now
            ]);
            // song_user_actions用
            $action_array[$i] = 0;
        }

        for ($i=1; $i<=10; $i++) {
            DB::table('songs')->insert([
                'member_id'   => array(1, 1, 2, 2, 3, 3, 4, 4, 5, 5)[$i-1],
                'title'       => 'テストソング'.$i,
                'file_name'   => 'test_name'.$i,
                'comment'     => 'dummy_comment'.$i,
                'advice_cnt'  => $i<=5? 10: 0,
                'created_at'  => $now,
                'updated_at'  => $now
            ]);
        }

        for ($i=1; $i<=5; $i++) {
            $count = 1;
            $key = $i + 5;
            while ($count <= 10) {
                $action_array[$key] += 1;
                DB::table('song_advice_lists')->insert([
                    'song_id'    => $i,
                    'member_id'  => $key,
                    'advice'     => 'アドバイス'.$key,
                    'created_at' => $now,
                    'updated_at' => $now
                ]);
                $count++;
                $key++;
            }
        }

        for ($i=1; $i<=50; $i++) {
            if ($i <= 5) {
                DB::table('song_user_actions')->insert([
                    'member_id'      => $i,
                    'get_advice_cnt' => $i==5? 10: 20,
                    'sing_song_cnt'  => 2,
                    'get_nice_cnt'   => 0,
                    'all_advice_cnt' => $action_array[$i],
                    'created_at'     => $now,
                    'updated_at'     => $now
                ]);
            } else {
                DB::table('song_user_actions')->insert([
                    'member_id'      => $i,
                    'all_advice_cnt' => $action_array[$i],
                    'created_at'     => $now,
                    'updated_at'     => $now
                ]);
            }
        }

        for ($i=1; $i<=5; $i++) {
            DB::table('song_user_questions')->insert([
                'member_id'  => $i,
                'question'   => 'お問い合わせ・要望'.$i,
                'created_at' => $now,
                'updated_at' => $now
            ]);
        }
    }
}