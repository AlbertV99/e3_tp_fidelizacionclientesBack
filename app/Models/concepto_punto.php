<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class concepto_punto extends Model{

    use SoftDeletes;
    public $table = 'concepto_punto';

    protected $fillable =[
        'descripcion',
        'puntos_requeridos'
    ];
}
