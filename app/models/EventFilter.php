<?php

class EventFilter extends Eloquent{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'filters';
	protected $guarded = array();


	/**
	 * Enums for Filtertypes
	 * 
	 */
	const EVENT = 0;
	const ATTRACTION = 1;

	public function screen()
	{
	    return $this->belongsTo('Screen');
	}

}