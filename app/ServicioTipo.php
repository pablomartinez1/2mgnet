<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServicioTipo extends Model
{
  protected $table = "servicio";
  protected $primaryKey = 'CD_Servicio';

  public function EventoServicio()
  {
      return $this->hasMany('App\EventoServicio', 'CD_Evento');
  }
}
