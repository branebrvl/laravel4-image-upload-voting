<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class TagsTableSeeder extends Seeder {

	public function run()
	{
		DB::table('tags')->delete();
		$faker = Faker::create();
    $usersIds = \PhotoUpload\Models\User::lists('id');

		foreach(range(1, 10) as $index)
		{
      $sentence = $faker->sentence(2);

			DB::table('tags')->insert([
        'name' => $sentence,
        'slug' => Str::slug($sentence, '-'),
        'user_id' => $faker->randomElement($usersIds),
        'created_at' => new DateTime,
        'updated_at' => new DateTime
			]);
		}
	}

}
