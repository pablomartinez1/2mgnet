<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventoContratacion extends Model
{
    protected $table = 'eventoscontrataciones';
    protected $primaryKey = 'CD_Evento';
    public $timestamps = false;

    protected $fillable = [
      'CD_Evento',
      'CD_Proveedor',
      'Total',
      'CD_CondPago'
    ];

    public function Evento()
    {
        return $this->belongsTo('App\Evento', 'CD_Evento');
    }

    public function Proveedor()
    {
        return $this->belongsTo('App\Proveedor', 'CD_Proveedor');
    }

    public function CondPago()
    {
        return $this->belongsTo('App\CondPago', 'CD_CondPago');
    }
}
