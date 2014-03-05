<?php

class AuthorsTableSeeder extends Seeder {

  public function run() 
  {
    // DB::table('authors')->truncate();
    DB::table('authors')->delete();

    $faker = Faker\Factory::create();

    for ($i = 0; $i < 100; $i++)
    {
      DB::table('authors')->insert([
          'name' => $faker->firstName(),
          'surname' => $faker->lastName(),
          'created_at' => new DateTime,
          'updated_at' => new DateTime
        ]);
    }
  }

}
