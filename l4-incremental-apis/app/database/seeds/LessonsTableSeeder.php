<?php

use Faker\Factory as Faker;

class LessonsTableSeeder extends Seeder {

  public function run(){

    DB::table('lessons')->truncate();
    DB::table('lessons')->delete();

    $faker = Faker::create();
    foreach(range(1,30) as $index)
    {
      DB::table('lessons')->insert([
        'title' => $faker->sentence(5),
        'body' => $faker->paragraph(4),      
        'some_bool' => $faker->boolean(),
        'created_at' => new DateTime,
        'updated_at' => new DateTime
      ]);
    }
  }
}
