<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsoPuntoDet extends Model{
    // use SoftDeletes;
    public $table = 'uso_punto_det';

    protected $fillable =[
        'id_uso_punto',
        'id_bolsa',
        'puntaje_utilizado',
    ];

    public function cabecera(){
        return $this->belongsTo(UsoPuntoCab::class , "id_uso_punto");
    }
    public function bolsa(){
        return $this->belongsTo(bolsas_punto::class , "id_bolsa");
    }
}
