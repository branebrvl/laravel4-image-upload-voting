<?php

use Faker\Factory as Faker;

class ImagesTableSeeder extends Seeder {

	public function run()
	{
		DB::table('images')->delete();
    $faker = Faker::create();
    $usersIds = \Evolve\Render\Models\User::lists('id');

    foreach(range(1,30) as $item)
    {
      $sentence = $faker->sentence(5);

		  DB::table('images')->insert([
        'title' => e($sentence),
        'slug' => Str::slug($sentence, '-'),
        'description' => e($faker->paragraph(4)),
        'img_min' => $faker->imageUrl(240, 170, 'abstract') . $faker->randomNumber(1,10),
        'img_big' => $faker->imageUrl(400, 300, 'abstract') . $faker->randomNumber(1,10),
        'show' => 1,
        'user_id' => $faker->randomElement($usersIds),
        'created_at' => $faker->dateTimeThisYear(),
        'updated_at' => $faker->dateTimeThisYear()
      ]);
    }
	}
}
