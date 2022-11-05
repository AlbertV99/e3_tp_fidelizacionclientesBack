<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class bolsas_punto extends Model
{
    use SoftDeletes;
    public $table = 'bolsas_punto';

    protected $fillable =[
        'id_cliente',
        'fecha_asignacion',
        'fecha_caducidad',
        'puntaje_asignado',
        'puntaje_utilizado',
        'puntos_saldo',
        'monto_saldo'

    ];
}
