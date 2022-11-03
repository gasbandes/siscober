<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    use HasFactory;


     public function entes()
    {
        return $this->belongsTo('App\Models\Ente', 'ente_id');
    }


    public function gerencia()
    {
        return $this->belongsTo('App\Models\Gerencia', 'gerencia_id');
    }


     public function getDisplayStatusAttribute()
    {
        return $this->status == 1 ? 'Activo' : 'Jubilado';
    }


    public function getDisplayNameAttribute()
     {
         return trim(str_replace( '  ', ' ',  "{$this->tx_nombres} {$this->tx_apellidos}")) ;
     }
}
