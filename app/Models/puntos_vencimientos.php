<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class puntos_vencimientos extends Model{
    
    public $table = 'puntos_vencimiento';
    protected $fillable =[
        'fecha_inicio',
        'fecha_fin',
        'duracion'
    ];
}
