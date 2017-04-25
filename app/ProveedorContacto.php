<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProveedorContacto extends Model
{
  protected $table = "proveedorescontacto";
  protected $primaryKey = 'CD_Proveedor';
  public $timestamps = false;

  protected $fillable = [
    'CD_Proveedor',
    'CD_Contacto'
  ];
}
