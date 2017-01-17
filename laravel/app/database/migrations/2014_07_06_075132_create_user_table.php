<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//creating user table
		$connection = 'mysql';
		Schema::connection($connection)->create('users', function($t)
        {

        	$t->increments('id');
        	$t->string('username', 30);
        	$t->string('password');
        	$t->string('email', 100);
        	$t->string('name', 300)->nullable();
        	$t->string('mobile', 15);
        	$t->integer('group_id');
            $t->text('apikey');
        	$t->dateTime('lastlogin');
        	$t->string('remember_token');
			$t->string('forgot_password')->nullable();
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
		//
		$connection = 'mysql';
		Schema::connection($connection)->drop('users');

	}

}
