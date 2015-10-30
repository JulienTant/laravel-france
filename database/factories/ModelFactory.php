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

$factory->define(LaravelFrance\User::class, function (Faker\Generator $faker) {
    return [
        'username' => $faker->name,
        'email' => $faker->email,
        'groups' => [],
        'remember_token' => str_random(10),
    ];
});


$factory->define(LaravelFrance\ForumsCategory::class, function (Faker\Generator $faker) {
    $name = $faker->words(rand(1, 3), true);

    return [
        'order' => $faker->randomDigitNotNull,
        'name' => $name,
        'slug' => str_slug($name),
        'background_color' => $faker->hexColor,
        'font_color' => $faker->hexColor,
        'description' => $faker->sentence,
    ];
});

$factory->define(LaravelFrance\ForumsTopic::class, function (Faker\Generator $faker) {
    $name = $faker->sentence;

    return [
        'forums_category_id' => '',
        'user_id' => '',
        'title' => $faker->sentence,
        'slug' => str_slug($name),
        'nb_messages' => 0,
    ];
});

$factory->define(LaravelFrance\ForumsMessage::class, function (Faker\Generator $faker) {
    return [
        'forums_topic_id' => '',
        'user_id' => '',
        'markdown' => $faker->sentences(3, true),
    ];
});