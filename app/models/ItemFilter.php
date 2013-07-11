<?php

class ItemFilter extends Eloquent{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'filters';
	protected $guarded = array();

	

	public function screen()
	{
	    return $this->belongsTo('Screen');
	}

}