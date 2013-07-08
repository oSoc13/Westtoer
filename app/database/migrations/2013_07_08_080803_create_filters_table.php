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

            // type of content: Event, Attraction,...
            $table->string('type'); 
            
            $table->integer('screen_id'); 

            // simple scoring
            //	-99: exclude
            //	 -1: less important
            //	  0: not rated
            //	  1: important
            $table->integer('score');

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