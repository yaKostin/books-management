<?php
return [
    'name' => $faker->sentence(3),
    'date' => $faker->date,
    'author_id' => rand(1, 10),
    'preview' => $faker->imageUrl(480, 640)//$faker->image( dirname(dirname(dirname(dirname(__FILE__)))) . '/frontend/web/images')
];