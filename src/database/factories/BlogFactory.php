<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use EventGo\Models\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'author_id' => $faker->randomNumber(2),
        'title' => $faker->sentence,
        'slug' => $faker->slug,
        'content' => $faker->text,
        'post_image' => $faker->imageUrl('1400', '380'),
        'preview_image' => $faker->imageUrl('771', '371'),
        'featured' => $faker->boolean,
        'published' => $faker->boolean,
        'published_at' => $faker->dateTime,
        'created_at' => $faker->dateTime,
    ];
});
