<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClienteFinal extends Model
{
	protected $table = 'clientefinal';
    protected $primaryKey = 'CD_ClienteFinal';
    public $timestamps = false;

    protected $fillable = [ 
    	'Nombre',
    	'CD_EmpresaRubro',
    	'FechaBaja'
    ];
}
