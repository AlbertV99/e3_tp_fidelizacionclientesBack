<?php

namespace App\Http\Controllers;

use App\Models\UsoPuntoCab;
use App\Models\UsoPuntoDet;
use App\Models\concepto_punto;
use App\Models\bolsas_punto;
use Illuminate\Http\Request;

class UsoPuntoCabController extends Controller
{
    public static function listarPanel($pag=0,$busqueda=""){
        $c_reg_panel = env('CANT_VALORES_PANEL');
        $c_paginas = ceil(UsoPuntoCab::count()/$c_reg_panel);
        $salto = $pag*$c_reg_panel;
        $query = UsoPuntoCab::select("uso_punto_cab.id","uso_punto_cab.fecha","cliente.nombre","cliente.apellido","cliente.nro_doc","concepto_punto.descripcion","uso_punto_cab.puntaje_utilizado")
        ->join("cliente","cliente.id","uso_punto_cab.id_cliente")
        ->join("concepto_punto","concepto_punto.id","uso_punto_cab.id_concepto_punto");


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
            $totalPuntaje = 0;

            $campos = $this->validate($peticion,[
                'id_cliente'=>'required|integer',
                'id_concepto_punto'=>'required|integer',
            ]);
            $campos["fecha"] = date("Y-m-d");
            $concepto_punto = concepto_punto::select("concepto_punto.puntos_requeridos")->where("id",$campos["id_concepto_punto"])->first();
            $valor_concepto = $concepto_punto->puntos_requeridos;
            $campos["puntaje_utilizado"] = $valor_concepto;

            $cant_puntos = bolsas_punto::where("id_cliente",$campos["id_cliente"])->sum("puntos_saldo");

            if($cant_puntos < $valor_concepto){
                throw new \Exception("No se tiene la cantidad de puntos necesarias para poder comprar el concepto", 1);
            }


            $usoPunto = UsoPuntoCab::create($campos);
            $bolsas_cliente = bolsas_punto::where("id_cliente",$campos["id_cliente"])->get();
            $puntos_utilizados = 0;
            $saldo_utilizado;
            $detalle = [];
            foreach ($bolsas_cliente as $key => $value) {
                $puntos_utilizados+= intval($value->puntos_saldo);

                if(intval($puntos_utilizados) < intval($valor_concepto)){
                    $detalle[]= New UsoPuntoDet([
                        "id_bolsa"=>$value->id,
                        "puntaje_utilizado"=>$value->puntos_saldo,
                    ]);
                    $value->update(["puntos_saldo"=>0]);
                }else{
                    $saldo_utilizado = $puntos_utilizados - $valor_concepto;
                    $detalle[]= New UsoPuntoDet([
                        "id_bolsa"=>$value->id,
                        "puntaje_utilizado"=>$saldo_utilizado,
                    ]);
                    $value->update(["puntos_saldo"=>$saldo_utilizado]);
                }

            }

            $usoPunto->detalle()->saveMany($detalle);
            

            return ["cod"=>"00","msg"=>"todo correcto","detalle"=>$bolsas_cliente];
        } catch (\Illuminate\Validation\ValidationException $e){
            return ["cod"=>"06","msg"=>"Error al insertar los datos","errores"=>[$e->errors() ]];
        }
        catch (\Exception $e) {
            return ["cod"=>"05","msg"=>"Error al insertar los datos","errores"=>[$e->getMessage() ]];
        }
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\Models\UsoPuntoCab  $usoPuntoCab
     * @return \Illuminate\Http\Response
     */
    public function show(UsoPuntoCab $usoPuntoCab)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UsoPuntoCab  $usoPuntoCab
     * @return \Illuminate\Http\Response
     */
    public function edit(UsoPuntoCab $usoPuntoCab)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UsoPuntoCab  $usoPuntoCab
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UsoPuntoCab $usoPuntoCab)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UsoPuntoCab  $usoPuntoCab
     * @return \Illuminate\Http\Response
     */
    public function destroy(UsoPuntoCab $usoPuntoCab)
    {
        //
    }
}
