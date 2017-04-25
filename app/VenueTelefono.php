<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VenueTelefono extends Model
{
	protected $table = "venuestelefono";
    protected $primaryKey = 'CD_Venue';
    public $timestamps = false;

    protected $fillable = [
    	'CD_Venue',
    	'CD_TelefonoTipo',
        'Telefono'
    ];
}
