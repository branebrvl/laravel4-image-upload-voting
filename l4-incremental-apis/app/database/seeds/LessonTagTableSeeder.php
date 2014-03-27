<?php

use Faker\Factory as Faker;

class LessonTagTableSeeder extends Seeder {

	public function run()
	{
    $faker = Faker::create();

    $lessonsIds = Lesson::lists('id');
    $tagsIds = Tag::lists('id');

    foreach(range(1,30) as $index)
    {
      DB::table('lesson_tag')->insert([
        'lesson_id' => $faker->randomElement($lessonsIds),
        'tag_id' => $faker->randomElement($tagsIds),
        // 'created_at' => new DateTime,
        // 'updated_at' => new DateTime
      ]);
    }
	}

}
