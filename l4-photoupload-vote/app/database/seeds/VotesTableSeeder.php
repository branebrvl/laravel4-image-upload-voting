<?php

use Faker\Factory as Faker;

class VotesTableSeeder extends Seeder {

	public function run()
	{
		DB::table('votes')->delete();

    $faker = Faker::create();

    foreach(range(1,30) as $item)
    {
		  DB::table('votes')->insert([
        'user_id' => $faker->randomNumber(1,11),
        'image_id' => $faker->randomNumber(1,30),
        'vote' => $faker->randomNumber(0,1),
        'notification' => $faker->randomNumber(0,1),
        'created_at' => new DateTime,
        'updated_at' => new DateTime
      ]);
    }
	}
}
