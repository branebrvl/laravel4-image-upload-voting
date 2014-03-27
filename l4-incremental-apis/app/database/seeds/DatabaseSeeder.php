<?php

class DatabaseSeeder extends Seeder {

  /**
   * tables 
   * 
   * @var mixed
   */
  private $tables = [
    'lessons',
    'tags',
    'lesson_tag'
  ];

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('LessonsTableSeeder');
		$this->call('TagsTableSeeder');
		$this->call('LessonTagTableSeeder');
	}

  protected function cleanDatabase()
  {
    DB::statement('SET FOREIGN_KEY_CHECKS=0');

    foreach($this->tables as $table)
    {
      DB::table($table)->truncate();
    }

    DB::statement('SET FOREIGN_KEY_CHECKS=1');
  }

}
