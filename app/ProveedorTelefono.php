<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProveedorTelefono extends Model
{
    protected $table = "proveedorestelefono";
    protected $primaryKey = 'CD_Proveedor';
    public $timestamps = false;

    protected $fillable = [
    	'CD_Proveedor',
    	'CD_TelefonoTipo',
      'Telefono'
    ];
}
