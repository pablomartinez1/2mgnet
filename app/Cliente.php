<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
		protected $table = 'clientes';
    protected $primaryKey = 'CD_Cliente';
    public $timestamps = false;

    protected $fillable = [
	    'Nombre',
	    'RazonSocial',
	    'CD_Pais',
	    'CD_Provincia',
	    'Localidad',
	    'Calle',
	    'CodPostal',
	    'CUIT',
	    'CD_SituacionIva',
	    'Web',
	    'Comisión',
	    'CD_ClienteTipo',
	    'CD_Canal',
	    'CD_EmpresaRubro',
	    'Notas',
	    'CD_CondPago',
	    'CD_ClienteClasificacion'
    ];

		public function Pais()
		{
			return $this->belongsTo('\App\Pais', 'CD_Pais');
		}

		public function Provincia()
		{
			return $this->belongsTo('\App\Provincia', 'CD_Provincia');
		}

		public function SituacionIva()
		{
			return $this->belongsTo('\App\SituacionIva', 'CD_SituacionIva');
		}

		public function ClienteTipo()
		{
			return $this->belongsTo('\App\ClienteTipo', 'CD_ClienteTipo');
		}

		public function Canal()
		{
			return $this->belongsTo('\App\Canal', 'CD_Canal');
		}

		public function EmpresaRubro()
		{
			return $this->belongsTo('\App\EmpresaRubro', 'CD_EmpresaRubro');
		}

		public function CondPago()
		{
			return $this->belongsTo('\App\CondPago', 'CD_CondPago');
		}

		public function ClienteClasificacion()
		{
			return $this->belongsTo('\App\ClienteClasificacion', 'CD_ClienteClasificacion');
		}
}
