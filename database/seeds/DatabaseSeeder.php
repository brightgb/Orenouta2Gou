<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run()
    {
        //初期設定
        $this->call(first_permission_registerSeed::class);
        $this->call(first_role_registerSeed::class);
        $this->call(first_admin_registerSeeder::class);
        $this->call(first_song_users_registerSeed::class);
        $this->call(first_manzai_users_registerSeed::class);
    }
}