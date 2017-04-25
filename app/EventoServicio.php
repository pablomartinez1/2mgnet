<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventoServicio extends Model
{
  protected $table = 'eventosservicios';
  protected $primaryKey = 'CD_Evento';
  public $timestamps = false;

  protected $fillable = [
    'CD_Evento',
    'CD_VenueSala',
    'CD_Servicio',
    'Total'
  ];

  public function Evento()
  {
      return $this->belongsTo('App\Evento', 'CD_Evento');
  }

  public function VenueSala()
  {
      return $this->belongsTo('App\VenueSala', 'CD_VenueSala');
  }

  public function ServicioTipo()
  {
      return $this->belongsTo('App\ServicioTipo', 'CD_Servicio');
  }
}
