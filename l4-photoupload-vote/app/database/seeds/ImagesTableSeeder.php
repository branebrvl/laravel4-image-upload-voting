<?php

use Faker\Factory as Faker;

class ImagesTableSeeder extends Seeder {

	public function run()
	{
		DB::table('images')->delete();

    $faker = Faker::create();

    foreach(range(1,30) as $item)
    {
		  DB::table('images')->insert([
        'user_id' => $faker->randomNumber(1,11),
        'img_init_min' => $faker->imageUrl(60, 80, 'abstract'),
        'img_init_big' => $faker->imageUrl(120, 140, 'abstract'),
        'img_final_min' => $faker->imageUrl(60, 80, 'technics'),
        'img_final_big' => $faker->imageUrl(120, 140, 'technics'),
        'ip' => $faker->ipv4(),
        'show' => 1,
        'created_at' => new DateTime,
        'updated_at' => new DateTime
      ]);
    }
	}
}
