<?php

use Faker\Factory as Faker;

class TagsTableSeeder extends Seeder {

	public function run()
	{
    $faker = Faker::create();

    foreach(range(1,30) as $index)
    {
      DB::table('tags')->insert([
        'name' => $faker->word,
        // 'created_at' => new DateTime,
        // 'updated_at' => new DateTime
        ]);
    }
	}

}
