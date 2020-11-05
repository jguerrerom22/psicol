<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comprador extends Model
{
    protected $table = "compradores";
    public $timestamp = false;
    protected $fillable = ['nombre', 'apellido', 'genero', 'documento', 'genero', 'email'];

    public function tickets()
    {
        return $this->belongsToMany(Ticket::class);
    }
}
