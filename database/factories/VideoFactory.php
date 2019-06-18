<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Video;
use App\User;
use Faker\Generator as Faker;

$factory->define(Video::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'file_name' => $faker->word.'.mp4',
        'file_size' => (float)$faker->randomDigit,
        'viewers_count' => '0',
    ];
});
