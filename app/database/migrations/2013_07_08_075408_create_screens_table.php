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
            $table->string('location');
            $table->float('long');
            $table->float('lat');
            $table->integer('radius')->default(15);
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