<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
	protected $table = 'eventos';
    protected $primaryKey = 'CD_Evento';
    public $timestamps = false;

    protected $fillable = [
	    'Nombre',
	    'CD_Cliente',
	    'CD_ClienteFinal',
	    'CD_EventoTipo',
	    'CD_EventoFrecuencia',
	    'CD_Venue',
	    'FechaDesde',
	    'FechaHasta',
	    'CD_EventoEstado',
	    'CD_Usuario',
	    'CD_CondPago',
	    'Notas',
	    'FechaConfirmada',
	    'NumeroPresupuesto',
	    'CD_EventoCodificacion',
	    'Licitacion',
	    'FechaArmadoDesde',
	    'FechaArmadoHasta',
	    'FechaArmadoConfirmada'
    ];

		public function EventoContratacion()
		{
				return $this->hasMany('App\EventoContratacion', 'CD_Evento');
		}

		public function EventoServicio()
		{
				return $this->hasMany('App\EventoServicio', 'CD_Evento');
		}

		public function EventoSala()
		{
			return $this->hasMany('\App\EventoSala', 'CD_VenueSala');
		}
}
