<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = "proveedores";
    protected $primaryKey = 'CD_Proveedor';
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
      'Horario',
      'CD_EmpresaRubro',
      'Notas'
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

    public function EmpresaRubro()
    {
      return $this->belongsTo('\App\EmpresaRubro', 'CD_EmpresaRubro');
    }

    public function EventoContratacion()
		{
				return $this->hasMany('App\EventoContratacion', 'CD_Proveedor');
		}
}
