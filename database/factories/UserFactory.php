<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use App\Post;
use App\Service;
use App\Tag;
use App\Testimonial;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});

//Create category factory
$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});

//Create comment factory
// $factory->define(Comment::class, function (Faker $faker) {
//     return [
//         'details' => $faker->sentence,
//     ];
// });

//Create tag factory
$factory->define(Tag::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});

//Create post factory
$factory->define(Post::class, function (Faker $faker) {
    return [
        'category_id' => rand(1, 10),
        'tag_id' => rand(1, 10),
        'user_id' => rand(1, 10),
        'title' => $faker->sentence,
        'details' => $faker->paragraph,
        'photo' => $faker->imageUrl,
    ];
});

//Create service factory
$factory->define(Service::class, function (Faker $faker) {
    return [
        'icon' => $faker->name,
        'title' => $faker->sentence,
        'details' => $faker->paragraph,
    ];
});

//Create testimonials factory
$factory->define(Testimonial::class, function (Faker $faker) {
    return [
        'photo' => $faker->imageUrl,
        'details' => $faker->paragraph,
        'name' => $faker->name,
    ];
});