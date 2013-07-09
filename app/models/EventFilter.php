<?php

class EventFilter extends Eloquent{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'filters';


	/**
	 * Enums for Filtertypes
	 * 
	 */
	const EVENT = 0;
	const ATTRACTION = 1;

	public function screen()
	{
	    return $this->belongs_to('Screen','screen_id');
	}

}