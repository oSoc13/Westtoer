<?php

class Screen extends Eloquent{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'screens';
	protected $guarded = array();


	/**
	 * Filter objects.
	 */
	public function filters()
    {
        return $this->hasMany('ItemFilter');
    }

    public function weather(){
        return $this->hasMany('Weather');
    }

}