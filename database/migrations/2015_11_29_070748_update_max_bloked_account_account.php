<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMaxBlokedAccountAccount extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('configuration', function(Blueprint $table)
		{
			$table->integer("nb_max_times_bloked")->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('configuration', function(Blueprint $table)
		{
			$table->dropColumn("nb_max_times_bloked");
		});
	}

}
