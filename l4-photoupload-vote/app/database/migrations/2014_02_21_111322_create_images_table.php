<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateImagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('images', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->string('title', 140);
      $table->string('slug')->unique();
      $table->text('description')->nullable()->default(NULL);
      $table->string('img_min');
			$table->string('img_big');
      $table->integer('vote_cache')->unsigned()->default(0);
      $table->integer('view_cache')->unsigned()->default(0);
			$table->boolean('show')->default(1);
      $table->timestamps();

      $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->onUpdate('cascade')
            ->onDelete('cascade');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('images');
	}

}
