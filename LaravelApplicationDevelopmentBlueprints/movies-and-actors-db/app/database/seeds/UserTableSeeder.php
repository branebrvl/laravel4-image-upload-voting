<?php

class UserTableSeeder extends Seeder {

  public function run()
  {
    /* Uncomment the below to wipe the table clean before populating */
    DB::table('users')->truncate(); 
    DB::table('users')->delete();   

    $users = array(
        'email' => 'branislav.vladisavljev@evolvemediallc.com',
        'password' => Hash::make('changeme!'),
        'created_at' => new DateTime,   
        'updated_at' => new DateTime    
    );                     

    DB::table('users')->insert($users);

    $this->command->info('users table seeded!');
  }

}
