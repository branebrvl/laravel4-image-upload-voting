<?php


class UsersTableSeeder extends Seeder {
	
	
	public function run()
	{
		
		User::truncate();
		
		
		User::create([
			'username' => 'ChrisSoutham',
			'email' => 'me@csoutham.com',
			'password' => 'password',
		]);
		
		User::create([
			'username' => 'LisaSoutham',
			'email' => 'wife@csoutham.com',
			'password' => 'password',
		]);

	}
	
}