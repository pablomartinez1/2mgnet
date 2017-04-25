<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
	protected $table = 'venues';
    protected $primaryKey = 'CD_Venue';
    public $timestamps = false;

    protected $fillable = [
	    'Nombre',
	    'CD_VenueTipo',
	    'Comisión',
	    'CD_Pais',
	    'CD_Provincia',
	    'Localidad',
	    'Calle',
	    'CodPostal',
	    'CUIT',
	    'CD_SituacionIva',
	    'Web',
	    'Notas',
			'Clausulas',
	    'FechaBaja'
    ];

    public function VenueTipo()
    {
        return $this->belongsTo('App\VenueTipo', 'CD_VenueTipo');
    }
}
