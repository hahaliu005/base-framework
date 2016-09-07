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

$factory->define(App\Admin::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});



$factory->define(\App\Video::class, function (Faker\Generator $faker) use ($factory) {
    return [
        'user_id' => $factory->create('App\Admin')->id,
        'title' => $faker->words(2,true),
        'status' => random_int(0, 10),
        'size' => $faker->randomDigit,
        'duration' => $faker->randomDigit,
        'play_count' => $faker->randomDigit,
        'file_name' => 'test',
        'intro' => $faker->sentence(8, true),
        'description' => $faker->sentence(100,true),
        'released_at' => $faker->dateTimeBetween('-3years','now'),
        'created_at' => $faker->dateTimeBetween('-4years','now'),
        'updated_at' => $faker->dateTimeBetween('-3months','now'),
    ];
});

$factory->define(\App\Tag::class, function (Faker\Generator $faker) use ($factory) {
    return [
        'name' => $faker->words(2,true),
        'created_at' => $faker->dateTimeBetween('-4years','now'),
    ];
});
