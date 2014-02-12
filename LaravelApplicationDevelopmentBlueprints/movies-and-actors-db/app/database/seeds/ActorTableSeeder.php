<?php

class ActorTableSeeder extends Seeder {

  public function run()
  {
    /* Uncomment the below to wipe the table clean before populating */
    // DB::table('actors')->truncate(); 
    DB::table('actors')->delete();   

    $faker = Faker\Factory::create();
    
    $actors = [];

    for($i=0; $i < 100; $i++){
      $actor = array(
        'name' => $faker->name,
        'created_at' => new DateTime,
        'updated_at' => new DateTime
      );

      DB::table('actors')->insert($actor);
    }

    $this->command->info('actors table seeded!');
  }

}
