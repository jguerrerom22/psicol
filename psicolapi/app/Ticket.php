<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    public $timestamps = false;
    protected $fillable = ['nombre', 'disponible', 'fecha_evento', 'lugar'];
}
