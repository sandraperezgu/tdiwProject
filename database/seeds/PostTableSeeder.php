<?php

use Illuminate\Database\Seeder;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       // factory(App\User::class, 10)->create();
        factory(App\Post::class, 10)->create();
       // factory(App\Tag::class,10)->create();
       // factory(App\TagPost::class,10)->create();
    }
}
