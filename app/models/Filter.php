<?php

class Filter extends Eloquent{


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

}