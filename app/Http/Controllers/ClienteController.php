<?php

namespace App\Http\Controllers;

use App\Models\cliente;
use Illuminate\Http\Request;
use App\Models\Nacionalidad;
use App\Models\tipo_documentos;

class ClienteController extends Controller{
    // private $c_reg_lista = env('CANT_VALORES_PANEL');
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public static function listarPanel($pag=0,$busqueda=""){
        $c_reg_panel = env('CANT_VALORES_PANEL');
        $c_paginas = ceil(cliente::count()/$c_reg_panel);
        $salto = $pag*$c_reg_panel;
        $query = cliente::select("cliente.nombre","cliente.apellido","cliente.mail","cliente.telefono","cliente.fecha_nacimiento","cliente.nro_doc","nacionalidad.nacionalidad","tipo_documento.tipo_doc")
        ->join("nacionalidad","cliente.id_nacionalidad","nacionalidad.id")
        ->join("tipo_documento","cliente.id_tipo_doc","tipo_documento.tipo_doc");

        /*User::select('users.nameUser', 'categories.nameCategory')
                ->join('categories', 'users.idUser', '=', 'categories.user_id')
                ->get();*/

        return ["cod"=>"00",
        "msg"=>"todo correcto",
        "pagina_actual"=>$pag,
        "cantidad_paginas"=>$c_paginas,
        "datos"=>$query->get()];







    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function nuevo(Request $peticion){

        try {
            $campos = $this->validate($peticion,[
                'nombre'=>'required|string',
                'apellido'=>'required|string',
                'mail'=>'required|string',
                'telefono'=>'required|string',
                'fecha_nacimiento'=>'required|string',
                'id_tipo_doc'=>'required|string',
                'id_nacionalidad'=>'required|string',
                'nro_doc'=>'required|string'
            ]);
            $cliente = cliente::create($campos);
        } catch (\Illuminate\Validation\ValidationException $e){
            return ["cod"=>"06","msg"=>"Error al insertar los datos","errores"=>[$e->errors() ]];
        }
        catch (\Exception $e) {
            return ["cod"=>"05","msg"=>"Error al insertar los datos"];
        }
        return ["cod"=>"00","msg"=>"todo correcto"];

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function modificar(Request $peticion,$id){
        try {
            $campos = $this->validate($peticion,[
                'nombre'=>'required|string',
                'apellido'=>'required|string',
                'mail'=>'required|string',
                'telefono'=>'required|string',
                'fecha_nacimiento'=>'required|string',
                'id_tipo_doc'=>'required|string',
                'id_nacionalidad'=>'required|string',
                'nro_doc'=>'required|string'
            ]);
            $cliente = cliente::where("id",$id);
            $cliente->update($campos);
            return ["cod"=>"00","msg"=>"todo correcto"];
        } catch (\Illuminate\Validation\ValidationException $e){
            return ["cod"=>"06","msg"=>"Error validando los datos","errores"=>[$e->errors() ]];
        }
        catch (\Exception $e) {
            return ["cod"=>"05","msg"=>"Error al actualizar los datos"];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function show(cliente $cliente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function edit(cliente $cliente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, cliente $cliente)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy(cliente $cliente)
    {
        //
    }
}
