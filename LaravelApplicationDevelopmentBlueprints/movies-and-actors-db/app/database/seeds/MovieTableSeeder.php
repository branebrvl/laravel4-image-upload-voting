<?php

class MovieTableSeeder extends Seeder {

  public function run()
  {

    // DB::table('movies')->truncate();
    DB::table('movies')->delete();

    $faker = Faker\Factory::create();
    
    for ($i = 0; $i < 100; $i++) {

      $movie = array(
        'name' => $faker->firstName,
        'release_year' => $faker->year,
        'created_at' => new DateTime,
        'updated_at' => new DateTime
      );

      DB::table('movies')->insert($movie);
    }

    $this->command->info('movies table seeded!');
  }

}
