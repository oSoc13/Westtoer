<?php

use Illuminate\Database\Migrations\Migration;

class CreateWeatherTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('weather', function($table)
        {

            $table->create();
            $table->timestamps();
            $table->increments('id');
            $table->integer('screen_id');
            $table->string('location');
            $table->float('lat',15,10);
            $table->float('long',15,10);
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('weather');
	}

}