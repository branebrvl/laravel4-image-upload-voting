<?php

class UsersTableSeeder extends Seeder {

  public function run()
  {
    // DB::table('users')->truncate();
    DB::table('users')->delete();

    $user = array(
      'email' => 'branislav.vladisavljev@evolvemediallc.com',
      'password' => Hash::make('changeme!'),
      'name' => 'Branislav Vladisavljev',
      'admin' => 1,
      'created_at' => new DateTime,
      'updated_at' => new DateTime
    );

    DB::table('users')->insert($user);

    $faker = Faker\Factory::create();

    for ($i = 0; $i < 10; $i++) {
      DB::table('users')->insert([
          'email' => $faker->email,
          'password' => Hash::make($faker->userName),
          'name' => $faker->name,
          'admin' => $faker->randomNumber(0,1),
          'created_at' => new DateTime,
          'updated_at' => new DateTime
        ]);
    }
  }

}
