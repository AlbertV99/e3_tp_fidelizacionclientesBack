<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class reglas_punto extends Model{
    public $table = 'reglas_punto';
    protected $fillable =[
        'limite_inferior',
        'limite_superior',
        'monto_equivalencia'
    ];

}
