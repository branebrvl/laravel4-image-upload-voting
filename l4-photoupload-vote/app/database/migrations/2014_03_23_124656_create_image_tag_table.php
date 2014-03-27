<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateImageTagTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('image_tag', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('image_id')->unsigned()->index();
			$table->integer('tag_id')->unsigned()->index();
			$table->timestamps();

			$table->foreign('image_id')
            ->references('id')
            ->on('images')
            ->onUpdate('cascade')
            ->onDelete('cascade');

			$table->foreign('tag_id')
            ->references('id')
            ->on('tags')
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
		Schema::drop('image_tag');
	}

}
