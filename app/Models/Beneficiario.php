<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beneficiario extends Model
{
    use HasFactory;


     protected $fillable = ['tx_nombres','tx_apellidos','cedula','titular','fecha_emision','usuario_id','status','ente'];
}
