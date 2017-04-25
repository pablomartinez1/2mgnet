<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CondPago extends Model
{
		protected $table = "condpago";
    protected $primaryKey = 'CD_CondPago';

		public function EventoContratacion()
		{
			return $this->hasMany('App\EventoContratacion', 'CD_CondPago'); 
		}
}
