<?php

class Screen extends Eloquent{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'screens';


	/**
	 * Filter objects.
	 */
	public function filters()
    {
        return $this->has_many('Filter');
    }

}