<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateActivitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$connection = 'mysql';
		Schema::connection($connection)->create('activities', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name')->nullable(); // differentiating activities like for group
			$table->string('parent_id')->nullable(); // if activitity for specific id
			$table->string('label')->nullable(); // any lable to put like warning, api, created etc
			$table->integer('user_id')->unsigned()->index()->nullable(); // activity persomed by the user
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->nullable();
			$table->text('content'); //content of the activity
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
		Schema::connection($connection)->drop('activities');
	}

}
