<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClienteTipo extends Model
{
	protected $table = "clientetipo";
  protected $primaryKey = 'CD_ClienteTipo';

	public function Cliente()
	{
			return $this->hasMany('\App\Cliente', 'CD_Cliente');
	}
}
