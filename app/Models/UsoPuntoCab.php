<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsoPuntoCab extends Model{
    // use SoftDeletes;
    public $table = 'uso_punto_cab';

    protected $fillable =[
        'id_cliente',
        'id_concepto_punto',
        'fecha',
        'puntaje_utilizado',
    ];

    public function detalle(){
        return $this->hasMany(UsoPuntoDet::class,"id_uso_punto");
    }
}
