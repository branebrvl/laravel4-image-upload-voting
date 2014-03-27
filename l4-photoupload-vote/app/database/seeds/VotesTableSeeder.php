<?php

use Faker\Factory as Faker;

class VotesTableSeeder extends Seeder {

	public function run()
	{
		DB::table('votes')->delete();
    $faker = Faker::create();
    $usersIds = \PhotoUpload\Models\User::lists('id');
    $imagesIds = \PhotoUpload\Models\Image::lists('id');

    foreach(range(1,30) as $item)
    {
		  DB::table('votes')->insert([
        'user_id' => $faker->randomElement($usersIds),
        'image_id' => $faker->randomElement($imagesIds),
        'vote' => $faker->randomNumber(0,1),
        'notification' => $faker->randomNumber(0,1),
        'created_at' => new DateTime,
        'updated_at' => new DateTime
      ]);
    }
	}
}
