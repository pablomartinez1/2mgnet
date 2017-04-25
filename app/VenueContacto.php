<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VenueContacto extends Model
{
	protected $table = "venuescontacto";
    protected $primaryKey = 'CD_Venue';
    public $timestamps = false;

    protected $fillable = [
    	'CD_Venue',
    	'CD_Contacto'
    ];
}
