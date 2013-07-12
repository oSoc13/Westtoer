<?php

use Illuminate\Database\Migrations\Migration;

class CreateScreensTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('screens', function($table)
        {
            $table->create();
            $table->timestamps();
            $table->increments('id');
            $table->string('name');
            $table->string('location');
            $table->float('lat',15,10);
            $table->float('long',15,10);
            $table->integer('radius')->default(15);
            $table->string('picasaname')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('screens');
    }

}