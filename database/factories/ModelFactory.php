<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});
$factory->define(App\Post::class, function (Faker\Generator $faker) {
    return [
        'title' =>$faker->text(80),
        'description' => $faker->text(255),
        'status'=>1,
        "user_id"=>1,
        "post_id"=>null,
        "visits_number"=>0
    ];
});
$factory->define(App\Tag::class, function (Faker\Generator $faker) {
    return [
        'name' =>$faker->text(80),
    ];
});
$factory->define(App\TagPost::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'tag_id' => rand(1,10),
        'post_id' => rand(1,10),
    ];
});
