<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class reglas_punto extends Model{
    use SoftDeletes;
    public $table = 'reglas_punto';
    protected $fillable =[
        'limite_inferior',
        'limite_superior',
        'monto_equivalencia'
    ];

}
