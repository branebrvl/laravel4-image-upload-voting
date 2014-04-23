<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{

    if (App::environment() === 'production' || App::environment() === 'prod') 
    {
      exit('I just stopped you getting fired.');
    }

		Eloquent::unguard();

		// $this->call('UserTableSeeder');
		$this->call('UsersTableSeeder');
		$this->call('ImagesTableSeeder');
		$this->call('VotesTableSeeder');
		$this->call('TagsTableSeeder');
		$this->call('ImageTagTableSeeder');
	}

}
