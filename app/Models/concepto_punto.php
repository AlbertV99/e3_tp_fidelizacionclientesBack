<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class concepto_punto extends Model
{
    protected $fillable =[
        'descripcion',
        'puntos_requeridos'
    ];
}
