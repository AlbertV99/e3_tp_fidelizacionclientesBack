<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cliente extends Model
{

    public $table = 'cliente';

    protected $fillable =[
        'nombre',
        'apellido',
        'mail',
        'telefono',
        'fecha_nacimiento',
        'id_tipo_doc',
        'id_nacionalidad',
        'nro_doc'
    ];
}
