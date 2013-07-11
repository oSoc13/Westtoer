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
        		  'location' => 'Bredene',
        		  'long' => '2.9667',
        		  'lat' => '51.2333',
        		  'radius' => '15')
        );


    }

}