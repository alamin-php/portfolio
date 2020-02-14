<?php

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
        $this->call(UsersTableSeeder::class);
        factory(App\Category::class, 10)->create();
        factory(App\Post::class, 20)->create();
        factory(App\Service::class, 10)->create();
        factory(App\Testimonial::class, 10)->create();
        factory(App\Tag::class, 10)->create();
        factory(App\User::class, 10)->create();
    }
}
