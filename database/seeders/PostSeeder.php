<?php

namespace Ngeblog\Database\Seeders;

use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 1000; $i++) {
            $user = \Ngeblog\User\Models\User::all()->random();

            $post = \Ngeblog\Post\Models\Post::factory()->make();

            $user->posts()->save($post);
        }
    }
}
