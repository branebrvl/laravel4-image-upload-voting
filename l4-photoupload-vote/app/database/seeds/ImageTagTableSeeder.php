<?php

use Faker\Factory as Faker;

class ImageTagTableSeeder extends Seeder {

	public function run()
	{
		DB::table('image_tag')->delete();
    $faker = Faker::create();
    $tagsIds = \Evolve\Render\Models\Tag::lists('id');
    $imagesIds = \Evolve\Render\Models\Image::lists('id');

    foreach(range(1,30) as $item)
    {
		  DB::table('image_tag')->insert([
        'tag_id' => $faker->randomElement($tagsIds),
        'image_id' => $faker->randomElement($imagesIds),
        'created_at' => new DateTime,
        'updated_at' => new DateTime
      ]);
    }
	}
}
