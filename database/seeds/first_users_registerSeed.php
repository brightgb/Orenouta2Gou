<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class first_users_registerSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        for ($i=1; $i<=5; $i++) {
            DB::table('songs')->insert([
                'title'       => 'テストソング'.$i,
                'file_name'   => 'test_name',
                'comment'     => 'dummy_comment'.$i,
                'advice_cnt'  => 10 * $i,
                'created_at'  => $now,
                'updated_at'  => $now
            ]);
        }

        $number = 1;
        for ($i=1; $i<=5; $i++) {
            for ($j=1; $j<=5; $j++) {
                $count = 1;
                while ($count <= 10) {
                    DB::table('advice_lists')->insert([
                        'song_id'    => $j,
                        'advice'     => 'アドバイス'.$number,
                        'created_at' => $now,
                        'updated_at' => $now
                    ]);
                    $number++;
                    $count++;
                }
            }
        }

        for ($i=1; $i<=5; $i++) {
            DB::table('user_questions')->insert([
                'question'   => 'お問い合わせ・要望'.$i,
                'created_at' => $now,
                'updated_at' => $now
            ]);
        }
    }
}