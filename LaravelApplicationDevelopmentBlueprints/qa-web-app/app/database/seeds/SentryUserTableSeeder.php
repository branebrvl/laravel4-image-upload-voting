<?php

class SentryUserTableSeeder extends Seeder {

    /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('users')->delete();

    Sentry::getUserProvider()->create(array(
      'email' => 'admin@admin.com',
      'password' => 'changeme!',
      'first_name' => 'John',
      'last_name' => 'Doe',
      'activated' => 1,
      'permissions' => array (
        'admin' => 1
      )
    ));
    
    $this->command->info('Sentry User table seeded!');
  }
}
