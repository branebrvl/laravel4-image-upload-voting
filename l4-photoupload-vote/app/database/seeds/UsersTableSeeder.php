<?php

use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder {

	public function run()
	{
		DB::table('users')->delete();

    $faker = Faker::create();

    $users = [
      'email' => 'branislav.vladisavljev@evolvemediallc.com',
      'username' => 'branislav',
      'password' => Hash::make('changeme'), 
      'admin' => 1,
      'created_at' => new DateTime,
      'updated_at' => new DateTime
    ];
		DB::table('users')->insert($users);

    foreach(range(1,10) as $itme)
    {
      DB::table('users')->insert([
        'email' => $faker->email,
        'username' => $faker->name,
        'password' => Hash::make('changeme'),
        'admin' => $faker->randomNumber(0,1), 
        'created_at' => new DateTime,
        'updated_at' => new DateTime
      ]);
    }
	}

}
