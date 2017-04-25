<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VenueSala extends Model
{
  protected $table = "venuessalas";
  protected $primaryKey = 'CD_VenueSala';
  public $timestamps = false;

  protected $fillable = [
    'CD_Venue',
    'Nombre',
    'Capacidad',
    'AlturaMax',
    'PuntosColgado',
    'UsoEnergia',
    'Notas',
    'FechaBaja'
  ];

  public function EventoServicio()
  {
      return $this->hasMany('\App\EventoServicio', 'CD_VenueSala');
  }

  public function EventoSala()
  {
    return $this->belongsTo('\App\EventoSala', 'CD_VenueSala');
  }
}
