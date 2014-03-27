<?php

use Faker\Factory as Faker;

class ImageTagTableSeeder extends Seeder {

	public function run()
	{
		DB::table('tags')->delete();
    $faker = Faker::create();
    $tagsIds = \PhotoUpload\Models\Tag::lists('id');
    $imagesIds = \PhotoUpload\Models\Image::lists('id');

    foreach(range(1,30) as $item)
    {
		  DB::table('votes')->insert([
        'tag_id' => $faker->randomElement($tagsIds),
        'image_id' => $faker->randomElement($imagesIds),
        'vote' => $faker->randomNumber(0,1),
        'notification' => $faker->randomNumber(0,1),
        'created_at' => new DateTime,
        'updated_at' => new DateTime
      ]);
    }
	}
}
