<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventoSala extends Model
{
    protected $table = 'eventossala';
    protected $primaryKey = 'CD_Evento';
    public $timestamps = false;

    protected $fillable = [
      'CD_VenueSala',
      'Asistentes'
    ];

    public function VenueSala()
    {
      return $this->hasMany('\App\VenueSala', 'CD_VenueSala');
    }
}
