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
        DB::table('screens')->delete();

        Screen::create(
            array('name' => 'Veld en duin',
                  'location' => 'Bredene',
                  'lat' => '51.23818985',
                  'long' => '2.9734925473485',
                  'radius' => '15')
        );
        DB::table('weather')->delete();
        
        Weather::create(
            array('screen_id' => '1',
                  'location' => 'Bredene',
                  'lat' => '51.23818985',
                  'long' => '2.9734925473485')
        );


    }

}