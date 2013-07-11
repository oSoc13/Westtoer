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

            /*
             |--------------------------------------------------------------------------
             | Type of content, using enum from Filter model.
             |--------------------------------------------------------------------------
             |
             | EVENT
             | ATTRACTION
             |
             */
            /*$contenttypes = array(
                EventFilter::EVENT,
                EventFilter::ATTRACTION,
            );
            $table->enum('type', $contenttypes)->default($contenttypes[0]);*/
            $table->string('item_id');
            
            $table->integer('screen_id'); 

            /*
             |--------------------------------------------------------------------------
             | Scoring based on certainty factors
             |--------------------------------------------------------------------------
             |
             | -1: exclude
             |  0: don't care/not scored
             |  1: important
             | 
             |  -0.5: less important
             |
             */
            $table->float('score')
                  ->default(0)
                  ->nullable();

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