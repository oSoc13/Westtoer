<?php

use Illuminate\Database\Migrations\Migration;

class CreateFiltersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('filters', function($table)
        {
            $table->create();
            $table->timestamps();
            $table->increments('id');
            $table->string('type'); 
            // type of content: Event, Attraction,...

            $table->integer('screen_id'); 

            $table->integer('score');
            // simple scoring
            //	-99: exclude
            //	 -1: less important
            //	  0: not rated
            //	  1: important

        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('filters');
	}

}