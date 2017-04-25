<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    protected $table = "contactos";
    protected $primaryKey = 'CD_Contacto';
    public $timestamps = false;

    protected $fillable = [
	    'Nombre',
	    'CD_ContactoTipo',
	    'CorreoCorporativo',
	    'CorreoPersonal',
	    'Skype',
	    'Notas'
    ];

    public function ContactoTipo()
    {
      return $this->belongsTo('\App\ContactoTipo', 'CD_ContactoTipo');
    }
}
