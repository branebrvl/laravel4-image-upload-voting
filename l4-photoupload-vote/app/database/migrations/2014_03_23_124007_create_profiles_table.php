<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProfilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('profiles', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
      $table->string('uid');
      $table->integer('user_id')->unsigned();
      $table->string('username')->nullable()->default(NULL);
      $table->string('name')->nullable()->default(NULL);
      $table->string('email')->nullable()->default(NULL);
      $table->string('first_name')->nullable()->default(NULL);
      $table->string('last_name')->nullable()->default(NULL);
      $table->string('location')->nullable()->default(NULL);
      $table->string('description')->nullable()->default(NULL);
      $table->string('image_url')->nullable()->default(NULL);
      $table->string('access_token')->nullable()->default(NULL);
      $table->string('access_token_secret');
      $table->timestamps();

      $table->foreign('user_id')
            ->references('id')->on('users')
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
		Schema::drop('profiles');
	}

}
