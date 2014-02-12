<?php

class ActorMovieTableSeeder extends Seeder {

  public function run()
  {
    /* Uncomment the below to wipe the table clean before populating */
    // DB::table('actor_movie')->truncate(); 
    DB::table('actor_movie')->delete();   

    $faker = Faker\Factory::create();
    
    $a_m= [];

    for($i=0; $i < 100; $i++){
      $a_m['actor_id'] = $faker->randomNumber(1,100);
      $a_m['movie_id'] = $faker->randomNumber(1,100);
      DB::table('actor_movie')->insert($a_m);
    }


    $this->command->info('actor_movie table seeded!');
  }

}
