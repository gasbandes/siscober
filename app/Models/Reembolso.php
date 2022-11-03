<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reembolso extends Model
{
    use HasFactory; 


    
    public function titular()
    {
        return $this->belongsTo('App\Models\Personal', 'personal_id');
    }

	public function proveedor()
    {
        return $this->belongsTo('App\Models\Proveedores', 'proveedor_id');
    }


    public function beneficiario()
    {
        return $this->belongsTo('App\Models\Beneficiario', 'beneficiario_id');
    }
}
