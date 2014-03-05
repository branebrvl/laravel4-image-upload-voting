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
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->string('img_init_min');
			$table->string('img_init_big');
			$table->string('img_final_min');
			$table->string('img_final_big');
			$table->string('ip');
			$table->boolean('show')->default(1);
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
      $table->timestamps();
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
