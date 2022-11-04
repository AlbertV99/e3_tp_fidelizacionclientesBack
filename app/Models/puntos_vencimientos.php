<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class puntos_vencimientos extends Model{
    use SoftDeletes;
    public $table = 'puntos_vencimiento';
    protected $fillable =[
        'fecha_inicio',
        'fecha_fin',
        'duracion'
    ];
}
