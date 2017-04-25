<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClienteTelefono extends Model
{
	protected $table = "clientestelefono";
    protected $primaryKey = 'CD_Cliente';
    public $timestamps = false;

    protected $fillable = [
    	'CD_Cliente',
    	'CD_TelefonoTipo',
        'Telefono'
    ];
}
