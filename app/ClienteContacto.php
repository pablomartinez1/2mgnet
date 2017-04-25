<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClienteContacto extends Model
{
	protected $table = "clientescontacto";
    protected $primaryKey = 'CD_Cliente';
    public $timestamps = false;

    protected $fillable = [
    	'CD_Cliente',
    	'CD_Contacto',
        'CargoArea',
    ];
}