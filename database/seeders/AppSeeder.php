<?php

namespace Ngeblog\Database\Seeders;

use Illuminate\Database\Seeder;

class AppSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \Ngeblog\User\Models\User::factory(10)->create();

        $this->call([
            \Ngeblog\Database\Seeders\PostSeeder::class,
            \Ngeblog\Database\Seeders\TagSeeder::class
        ]);
    }
}
