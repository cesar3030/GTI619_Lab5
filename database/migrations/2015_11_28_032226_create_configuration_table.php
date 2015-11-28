<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigurationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configuration', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('number_attempt_allowed');
            $table->integer('time_restriction');
            $table->integer('number_last_password_disallowed');
            $table->integer('password_time_life'); // time in seconds
            $table->integer('password_min_length');// minimal length for a password
            $table->integer('password_lower_case_required');// 1: at least 1 lower case required 0: no lower case required
            $table->integer('password_upper_case_required');// 1: at least 1 upper case required 0: no upper case required
            $table->integer('password_special_characters_required');// 1: at least 1 special character required 0: no special character required
            $table->integer('password_number_required');// 1: at least 1 number required 0: no number required
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('configuration');
    }
}
