<?php

class Weather extends Eloquent{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'weather';
	protected $guarded = array();

	

	public function screen()
	{
	    return $this->belongsTo('Screen');
	}

}