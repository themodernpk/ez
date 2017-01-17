<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotificationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$connection = 'mysql';
		Schema::connection($connection)->create('notifications', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->boolean('read')->default(0);
			$table->boolean('realtime')->nullable();
			$table->boolean('email_sent')->default(0);
			$table->string('icon')->nullable();
			$table->string('link')->nullable();
			$table->text('content');
			$table->timestamps();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		$connection = 'mysql';
		Schema::connection($connection)->drop('notifications');
	}

}
