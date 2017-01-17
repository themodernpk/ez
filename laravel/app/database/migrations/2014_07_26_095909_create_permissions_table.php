<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//create permission table & pivot table
		$connection = 'mysql';
		Schema::connection($connection)->create('permissions', function($t)
        {
        	$t->increments('id');
        	$t->string('name');
        	$t->string('slug');
        	$t->boolean('active')->default(1);
			$t->integer('created_by')->unsigned()->nullable();
			$t->foreign('created_by')->references('id')->on('users')->onDelete('set null')->after('active');

			$t->integer('modified_by')->unsigned()->nullable();
			$t->foreign('modified_by')->references('id')->on('users')->onDelete('set null')->after('created_by');

			$t->integer('deleted_by')->unsigned()->nullable();
			$t->foreign('deleted_by')->references('id')->on('users')->onDelete('set null')->after('modified_by');
        	$t->timestamps();
        	$t->softDeletes();
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
		Schema::connection($connection)->drop('permissions');
	}

}
