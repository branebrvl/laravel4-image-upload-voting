<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVotesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('votes', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('image_id')->unsigned();
			$table->boolean('vote');
			$table->boolean('notification');
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
      $table->foreign('image_id')->references('id')->on('images')->onDelete('cascade');
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
		Schema::drop('votes');
	}

}
