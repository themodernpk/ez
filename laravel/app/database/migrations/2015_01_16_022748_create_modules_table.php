<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateModulesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$connection = 'mysql';
		Schema::connection($connection)->create('modules', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('version');
			$table->boolean('active')->default(1);
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
		Schema::connection($connection)->drop('modules');
	}

}
