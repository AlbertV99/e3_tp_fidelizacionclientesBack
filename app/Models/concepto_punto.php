<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class concepto_punto extends Model{

    public $table = 'concepto_punto';

    protected $fillable =[
        'descripcion',
        'puntos_requeridos'
    ];
}
