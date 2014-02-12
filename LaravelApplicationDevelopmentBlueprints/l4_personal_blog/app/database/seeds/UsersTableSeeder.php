<?php

class UsersTableSeeder extends Seeder {

    public function run()
    {
        /* Uncomment the below to wipe the table clean before populating */
        DB::table('users')->truncate();
        DB::table('users')->delete();

        /* TODO Add admin user */
        $users = array(
            'email' => 'branislav.vladisavljev@evolvemediallc.com',
            'password' => Hash::make('changeme!'),
            'name' => 'Branislav Vladisavljev',
            'created_at' => new DateTime,
            'updated_at' => new DateTime
        );

        DB::table('users')->insert($users);

        $users = array(
            'email' => 'jairo.espinosa@evolvemediallc.com',
            'password' => Hash::make('changeme!'),
            'name' => 'Jairo Espinosa',
            'created_at' => new DateTime,
            'updated_at' => new DateTime
        );

        DB::table('users')->insert($users);
    }

}
