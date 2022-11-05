<?php

namespace App\Http\Controllers;

use App\Models\UsoPuntoCab;
use App\Models\UsoPuntoDet;
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
            $campos["puntaje_utilizado"] = 0;
            $usoPunto = UsoPuntoCab::create($campos);

            foreach ($peticion->get("detalle") as $key => $value) {
                $totalPuntaje+=$value["puntaje_utilizado"];
                $rDetalle = new UsoPuntoDet($value);
                $usoPunto->detalle()->save($rDetalle);
            }
            $usoPuntoUpd = UsoPuntoCab::find($usoPunto["id"]);
            $usoPuntoUpd->update(["puntaje_utilizado"=>$totalPuntaje]);
            return ["cod"=>"00","msg"=>"todo correcto"];
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
