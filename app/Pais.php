<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
		protected $table = "pais";
    protected $primaryKey = 'CD_Pais';

    public function Clientes()
    {
        return $this->hasMany('App\Pais', 'CD_Pais');
    }
}
