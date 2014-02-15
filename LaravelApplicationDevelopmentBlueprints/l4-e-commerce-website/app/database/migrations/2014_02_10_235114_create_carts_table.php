<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCartsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('carts', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('member_id')->unsigned()->default(0);
			$table->integer('book_id')->unsigned()->default(0);
			$table->integer('amount')->default(0);
			$table->decimal('total', 10, 2);
      $table->foreign('member_id')->references('id')->on('users')->onDelete('cascade');
      $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
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
		Schema::drop('carts');
	}

}
