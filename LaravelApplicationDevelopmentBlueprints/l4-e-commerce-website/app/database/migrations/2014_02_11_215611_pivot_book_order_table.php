<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class PivotBookOrderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('book_order', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('book_id')->unsigned()->index();
			$table->integer('order_id')->unsigned()->index();
      $table->integer('amount');
      $table->decimal('price', 10, 2);
      $table->decimal('total', 10, 2);
			$table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
			$table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
		});
	}



	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('book_order');
	}

}
