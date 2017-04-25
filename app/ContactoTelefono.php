<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactoTelefono extends Model
{
	protected $table = "contactostelefono";
    protected $primaryKey = 'CD_Contacto';
    public $timestamps = false;

    protected $fillable = [
    	'CD_Contacto',
    	'CD_TelefonoTipo',
        'Telefono'
    ];
}
