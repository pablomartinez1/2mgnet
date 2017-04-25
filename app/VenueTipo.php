<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VenueTipo extends Model
{
	protected $table = "venuetipo";
  protected $primaryKey = 'CD_VenueTipo';

	public function Venues()
	{
			return $this->hasMany('\App\Venue', 'CD_Venue');
	}
}
