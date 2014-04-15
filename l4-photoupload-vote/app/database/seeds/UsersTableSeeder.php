<?php

use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder {

	public function run()
	{
		DB::table('users')->delete();
    $faker = Faker::create();

    // Create admin users
    DB::table('users')->insert([
      'email' => 'branislav.vladisavljev@evolvemediallc.com',
      'username' => 'branislav',
      'password' => Hash::make('changeme'), 
      'admin' => 1,
      'created_at' => new DateTime,
      'updated_at' => new DateTime
    ]);

    DB::table('users')->insert([
      'email' => 'admin@admin.com',
      'username' => 'admin',
      'password' => Hash::make('changeme'), 
      'admin' => 1,
      'created_at' => new DateTime,
      'updated_at' => new DateTime
    ]);

    foreach(range(1,9) as $itme)
    {
      DB::table('users')->insert([
        'email' => $faker->email,
        'username' => $faker->word,
        'password' => Hash::make('changeme'),
        'admin' => $faker->randomNumber(0,1), 
        'created_at' => new DateTime,
        'updated_at' => new DateTime
      ]);
    }
	}

}
