<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNeedNewPassordTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->integer("need_reset_password")->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->dropColumn("need_reset_password");
		});
	}

}
