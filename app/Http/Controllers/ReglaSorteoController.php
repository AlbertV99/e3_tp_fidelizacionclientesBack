<?php

namespace App\Http\Controllers;

use App\Models\ReglaSorteo;
use Illuminate\Http\Request;

class ReglaSorteoController extends Controller{


    public static function listarPanel($pag=0,$busqueda=""){
        $c_reg_panel = env('CANT_VALORES_PANEL');
        $c_paginas = ceil(ReglaSorteo::count()/$c_reg_panel);
        $salto = $pag*$c_reg_panel;
        $query = ReglaSorteo::select("regla_sorteo.id","regla_sorteo.limite_inferior","regla_sorteo.limite_superior","regla_sorteo.fecha_sorteo","regla_sorteo.descripcion","cliente.nombre","cliente.apellido","cliente.mail")
        ->leftJoin('cliente','cliente.id','=','regla_sorteo.id_cliente_ganador');

        return ["cod"=>"00",
        "msg"=>"todo correcto",
        "pagina_actual"=>$pag,
        "cantidad_paginas"=>$c_paginas,
        "datos"=>$query->get()];

    }

    public function modificar(Request $peticion,$id){
        try {
            $campos = $this->validate($peticion,[
                'limite_inferior'=>'required|date',
                'limite_superior'=>'required|date',
                'descripcion'=>'required|integer'
                'fecha_sorteo'=>'required|integer'
            ]);
            $puntos_vencimientos = ReglaSorteo::where("id",$id);
            if(isset($puntos_vencimiento->id_cliente_ganador )){
                throw new Exception('No se puede modificar, el sorteo ya fue realizado');
            }
            return ["cod"=>"00","msg"=>"todo correcto"];
        } catch (\Illuminate\Validation\ValidationException $e){
            return ["cod"=>"06","msg"=>"Error validando los datos","errores"=>[$e->errors() ]];
        }
        catch (\Exception $e) {
            return ["cod"=>"05","msg"=>"Error al actualizar los datos"];
        }
    }



    public function nuevo(Request $peticion){

        try {
            $campos = $this->validate($peticion,[
                'limite_inferior'=>'required|integer',
                'limite_superior'=>'required|integer',
                'descripcion'=>'required|string',
                'fecha_sorteo'=>'required|date'
            ]);
            if($campos ['limite_inferior'] > $campos ['limite_superior'] ){
                throw new Exception('Limite inferior debe ser menor al limite superior');
            }
            $reglas_punto = ReglaSorteo::create($campos);
        } catch (\Illuminate\Validation\ValidationException $e){
            return ["cod"=>"06","msg"=>"Error al insertar los datos","errores"=>[$e->errors() ]];
        }
        catch (\Exception $e) {
            return ["cod"=>"05","msg"=>"Error al insertar los datos"];
        }
        return ["cod"=>"00","msg"=>"todo correcto"];

    }

    public function eliminar($id){

        try {
            $usuario = ReglaSorteo::where("id",$id);
            if(isset($puntos_vencimiento->id_cliente_ganador )){
                throw new Exception('No se puede modificar, el sorteo ya fue realizado');
            }
            $usuario->delete();

            return ["cod"=>"00","msg"=>"todo correcto"];
        } catch (\Exception $e) {
            return ["cod"=>"08","msg"=>"Error al eliminar el registro","errores"=>[$e->getMessage() ]];
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReglaSorteo  $reglaSorteo
     * @return \Illuminate\Http\Response
     */
    public function show(ReglaSorteo $reglaSorteo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReglaSorteo  $reglaSorteo
     * @return \Illuminate\Http\Response
     */
    public function edit(ReglaSorteo $reglaSorteo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ReglaSorteo  $reglaSorteo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReglaSorteo $reglaSorteo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReglaSorteo  $reglaSorteo
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReglaSorteo $reglaSorteo)
    {
        //
    }
}
