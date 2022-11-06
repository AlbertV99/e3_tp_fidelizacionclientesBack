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
    public function  listar_cliente_vencido($dias){
        $fecha_actual= date("Y-m-d");
        $calculo_fecha = date("Y-m-d",strtotime($fecha_actual."+ ".$dias." days"));
        $query = cliente::select("cliente.id","cliente.nombre","cliente.apellido", "bolsas_punto.puntos_saldo", "cliente.mail","cliente.telefono","cliente.fecha_nacimiento","cliente.nro_doc","nacionalidad.nacionalidad","tipo_documento.tipo_doc")
        ->join("bolsas_punto", "bolsas_punto.id_cliente", "cliente.id")
        ->join("nacionalidad","cliente.id_nacionalidad","nacionalidad.id")
        ->join("tipo_documento","cliente.id_tipo_doc","tipo_documento.id")
        ->where("bolsas_punto.fecha_caducidad" , '=', $calculo_fecha);
        
        return ["cod"=>"00",
        "msg"=>"todo correcto",
        "datos"=>$query->get()];
    }

    public static function listarPanel($pag=0,$busqueda=""){
        $c_reg_panel = env('CANT_VALORES_PANEL');
        $c_paginas = ceil(cliente::count()/$c_reg_panel);
        $salto = $pag*$c_reg_panel;
        $query = cliente::select("cliente.id","cliente.nombre","cliente.apellido","cliente.mail","cliente.telefono","cliente.fecha_nacimiento","cliente.nro_doc","nacionalidad.nacionalidad","tipo_documento.tipo_doc")
        ->join("nacionalidad","cliente.id_nacionalidad","nacionalidad.id")
        ->join("tipo_documento","cliente.id_tipo_doc","tipo_documento.id");

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
                'fecha_nacimiento'=>'required|date',
                'id_tipo_doc'=>'required|string',
                'id_nacionalidad'=>'required|string',
                'nro_doc'=>'required|string'
            ]);
            $cliente = cliente::create($campos);
            return ["cod"=>"00","msg"=>"todo correcto"];
        } catch (\Illuminate\Validation\ValidationException $e){
            return ["cod"=>"06","msg"=>"Error al insertar los datos","errores"=>[$e->errors() ]];
        }
        catch (\Exception $e) {
            return ["cod"=>"05","msg"=>"Error al insertar los datos","errores"=>[$e->getMessage() ]];
        }
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

    public function eliminar($id){

        try {
            $usuario = cliente::where("id",$id);
            $usuario->delete();

            return ["cod"=>"00","msg"=>"todo correcto"];
        } catch (\Exception $e) {
            return ["cod"=>"08","msg"=>"Error al eliminar el registro","errores"=>[$e->getMessage() ]];
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
