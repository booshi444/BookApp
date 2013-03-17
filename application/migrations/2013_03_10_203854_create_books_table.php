<?php

class Create_Books_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('books', function($table){
			$table->increments('id');
			$table->string('book_name');
			$table->string('author_name');
			$table->string('is_read');
			$table->timestamps();
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('books');
	}

}