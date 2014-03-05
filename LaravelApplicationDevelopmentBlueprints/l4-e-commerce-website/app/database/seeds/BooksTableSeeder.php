<?php

class BooksTableSeeder extends Seeder {

  public function run() 
  {
    // DB::table('books')->truncate();
    DB::table('books')->delete();

    $faker = Faker\Factory::create();

    for ($i = 0; $i < 100; $i++) {
      DB::table('books')->insert([
          'title' => $faker->company,
          'isbn' => $faker->randomNumber(13),
          'cover' => $faker->imageUrl(290,218,'technics') . $faker->randomNumber(1,10),
          'price' => $faker->randomFloat(2, 5, 99999999),
          'author_id' => $faker->randomNumber(1,99),
          'created_at' => new DateTime,
          'updated_at' => new DateTime
        ]);
    }
  }

}
