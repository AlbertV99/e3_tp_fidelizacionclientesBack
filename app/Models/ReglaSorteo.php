<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReglaSorteo extends Model{
    public $table = 'cliente';

    protected $fillable =[
        'descripcion',
        'fecha_sorteo',
        'limite_inferior',
        'limite_superior',
        'id_cliente_ganador'
    ];
}
