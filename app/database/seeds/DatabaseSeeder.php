<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('ScreenTableSeeder');
	}

}

class ScreenTableSeeder extends Seeder {

    public function run()
    {
        //DB::table('screens')->delete();

        Screen::create(
        	array('name' => 'Veld en duin',
        		  'location' => 'Brugge',
        		  'long' => '2.93',
        		  'lat' => '51.23',
        		  'radius' => '15')
        );


    }

}