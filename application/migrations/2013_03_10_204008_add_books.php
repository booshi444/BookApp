<?php

class Add_Books {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::table('books')->insert(array(
			'book_name'=>'Building Businesses',
			'author_name'=>'Booshi',
			'is_read'=>'Yes',
			'created_at'=>date('Y-m-d H:m:s'),
			'updated_at'=>date('Y-m-d H:m:s')
		));

		DB::table('books')->insert(array(
			'book_name'=>'The Dark Room',
			'author_name'=>'Nagabhushan Sundarakrishna',
			'is_read'=>'No',
			'created_at'=>date('Y-m-d H:m:s'),
			'updated_at'=>date('Y-m-d H:m:s')
		));
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::table('books')->where('book_name', '=', 'Building Businesses')->delete();
		DB::table('books')->where('book_name', '=', 'The Dark Room')->delete();
	}

}