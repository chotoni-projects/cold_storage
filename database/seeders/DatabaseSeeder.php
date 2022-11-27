<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(10)->create();
        DB::table('settings')->insert([
        	'from'          => 'mpdi.sub@ptjas.co.id',
            'to'            => 'coldstorage.sub@ptjas.co.id',
            'interval'      => 15,
            'host'          => '50.1.1.7',
            'port'          => 25,
            'notification'  => 'enable'
        ]);
    }
}
