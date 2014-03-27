<?php

use Faker\Factory as Faker;

class ImagesTableSeeder extends Seeder {

	public function run()
	{
		DB::table('images')->delete();
    $faker = Faker::create();
    $usersIds = \PhotoUpload\Models\User::lists('id');

    foreach(range(1,30) as $item)
    {
      $sentence = $faker->sentence(5);

		  DB::table('images')->insert([
        'title' => e($sentence),
        'slug' => Str::slug($sentence, '-'),
        'description' => e($faker->paragraph(4)),
        'img_init_min' => $faker->imageUrl(60, 80, 'abstract'),
        'img_init_big' => $faker->imageUrl(120, 140, 'abstract'),
        'img_final_min' => $faker->imageUrl(60, 80, 'technics'),
        'img_final_big' => $faker->imageUrl(120, 140, 'technics'),
        'ip' => $faker->ipv4(),
        'show' => 1,
        'user_id' => $faker->randomElement($usersIds),
        'created_at' => new DateTime,
        'updated_at' => new DateTime
      ]);
    }
	}
}
