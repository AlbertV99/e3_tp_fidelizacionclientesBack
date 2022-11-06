<?php

namespace App\Http\Controllers;

use App\Models\bolsas_punto;
use Illuminate\Http\Request;
use App\Models\cliente;
use  App\Http\Controllers\ReglasPuntoController;

class BolsasPuntoController extends Controller
{
   // private $c_reg_lista = env('CANT_VALORES_PANEL');
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function  listar_bolsa_punto_cliente($id){
        $query = bolsas_punto::select("bolsas_punto.id","cliente.nombre","cliente.apellido","cliente.nro_doc", "bolsas_punto.fecha_asignacion", "bolsas_punto.fecha_caducidad", "bolsas_punto.puntaje_asignado", "bolsas_punto.puntaje_utilizado", "bolsas_punto.puntos_saldo", "bolsas_punto.monto_saldo")
        ->join("cliente","cliente.id", "bolsas_punto.id_cliente")
        ->where("cliente.id" , '=', $id);
        
        return ["cod"=>"00",
        "msg"=>"todo correcto",
        "datos"=>$query->get()];
    }
    public function  listar_bolsa_punto_rango($rango_inferior, $rango_superior){
        $query = bolsas_punto::select("bolsas_punto.id","cliente.nombre","cliente.apellido","cliente.nro_doc", "bolsas_punto.fecha_asignacion", "bolsas_punto.fecha_caducidad", "bolsas_punto.puntaje_asignado", "bolsas_punto.puntaje_utilizado", "bolsas_punto.puntos_saldo", "bolsas_punto.monto_saldo")
        ->join("cliente","cliente.id", "bolsas_punto.id_cliente")
        ->where("bolsas_punto.puntos_saldo" , '>=', $rango_inferior)
        ->where("bolsas_punto.puntos_saldo" , '<=', $rango_superior);
        
        return ["cod"=>"00",
        "msg"=>"todo correcto",
        "datos"=>$query->get()];
    }

    public static function listarPanel($pag=0,$busqueda=""){
        $c_reg_panel = env('CANT_VALORES_PANEL');
        $c_paginas = ceil(bolsas_punto::count()/$c_reg_panel);
        $salto = $pag*$c_reg_panel;
        $query = bolsas_punto::select("bolsas_punto.id","bolsas_punto.id_cliente","bolsas_punto.fecha_asignacion","bolsas_punto.fecha_caducidad","bolsas_punto.puntaje_asignado","bolsas_punto.puntaje_utilizado","bolsas_punto.puntos_saldo","bolsas_punto.monto_saldo")
        ->join("cliente","bolsas_punto.id_cliente","cliente.id");

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
                'id_cliente'=>'required|integer',
                'fecha_asignacion'=>'required|date',
                'fecha_caducidad'=>'required|date',
                'puntaje_asignado'=>'required|integer',
                'puntaje_utilizado'=>'required|integer',
                'puntos_saldo'=>'required|integer',
                'monto_saldo'=>'required|integer'
            ]);
            $bolsas_punto = bolsas_punto::create($campos);
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
                'id_cliente'=>'required|integer',
                'fecha_asignacion'=>'required|date',
                'fecha_caducidad'=>'required|date',
                'puntaje_asignado'=>'required|integer',
                'puntaje_utilizado'=>'required|integer',
                'puntos_saldo'=>'required|integer',
                'monto_saldo'=>'required|integer'
            ]);
            $bolsas_punto = bolsas_punto::where("id",$id);
            $bolsas_punto->update($campos);
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
            $usuario = bolsas_punto::where("id",$id);
            $usuario->delete();

            return ["cod"=>"00","msg"=>"todo correcto"];
        } catch (\Exception $e) {
            return ["cod"=>"08","msg"=>"Error al eliminar el registro","errores"=>[$e->getMessage() ]];
        }
    }


    public function listarrango($inferior = 0,$superior = 0){
        $c_reg_panel = env('CANT_VALORES_PANEL');
        $c_paginas = ceil(bolsas_punto::count()/$c_reg_panel);
        $superior = ($superior == 0 ) ? DB::table("bolsas_puntos")->max("monto_saldo") : $superior;
        $salto = $pag*$c_reg_panel;
        $query = bolsas_punto::select("bolsas_punto.id","bolsas_punto.id_cliente","bolsas_punto.fecha_asignacion","bolsas_punto.fecha_caducidad","bolsas_punto.puntaje_asignado","bolsas_punto.puntaje_utilizado","bolsas_punto.puntos_saldo","bolsas_punto.monto_saldo")
        ->join("cliente","bolsas_punto.id_cliente","cliente.id")
        ->where("bolsas_punto.monto_saldo" , '>', $inferior )
        ->where("bolsas_punto.monto_saldo" , '<', $superior )
        ->get();

        return ["cod"=>"00",
        "msg"=>"todo correcto",
        "pagina_actual"=>$pag,
        "cantidad_paginas"=>$c_paginas,
        "datos"=>$query->get()];
    }


    public function cargapuntos (Request $peticion){
        try {
            $puntos = (new ReglasPuntoController)-> devolverpunto($peticion -> input('monto_saldo'));
            $nueva_bolsa = [
                'id_cliente' => $peticion -> input('id_cliente'),
                'fecha_asignacion'=> date("Y-m-d"),
                'fecha_caducidad' => date("Y-m-d"),
                'puntaje_asignado' => $puntos['puntaje_asignado'],
                'puntaje_utilizado' => 0,
                'puntos_saldo' => $puntos['puntaje_asignado'],
                'monto_saldo' => $peticion -> input('monto_saldo')
            ];
            $bolsas_punto = bolsas_punto::create($nueva_bolsa);
            return ["cod"=>"00","msg"=>"todo correcto"];
        } catch (\Illuminate\Validation\ValidationException $e){
            return ["cod"=>"06","msg"=>"Error al insertar los datos","errores"=>[$e->errors() ]];
        }
        catch (\Exception $e) {
            return ["cod"=>"05","msg"=>"Error al insertar los datos","errores"=>[$e->getMessage() ]];
            
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\bolsas_punto  $bolsas_punto
     * @return \Illuminate\Http\Response
     */
    public function show(bolsas_punto $bolsas_punto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\bolsas_punto  $bolsas_punto
     * @return \Illuminate\Http\Response
     */
    public function edit(bolsas_punto $bolsas_punto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\bolsas_punto  $bolsas_punto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, bolsas_punto $bolsas_punto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\bolsas_punto  $bolsas_punto
     * @return \Illuminate\Http\Response
     */
    public function destroy(bolsas_punto $bolsas_punto)
    {
        //
    }
}
