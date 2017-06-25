<?php

use Illuminate\Database\Seeder;

class OAuthClientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('oauth_clients')->insert([
            [
                'id' => 'appid2',
                'secret' => 'secret',
                'name' => 'AngularApp',
                'created_at' =>  '2017-06-25 00:00:00:00',
                'updated_at' =>  '2017-06-25 00:00:00:00'
            ]
        ]);
    }
}
