<?php

namespace App\Http\Controllers;

use App\Models\concepto_punto;
use Illuminate\Http\Request;
//'descripcion','puntos_requeridos'
class ConceptoPuntoController extends Controller
{
    public static function listarPanel($pag=0,$busqueda=""){
        $c_reg_panel = env('CANT_VALORES_PANEL');
        $c_paginas = ceil(concepto_punto::count()/$c_reg_panel);
        $salto = $pag*$c_reg_panel;
        $query = concepto_punto::select("concepto_punto.id","concepto_punto.descripcion", "concepto_punto.puntos_requeridos");

        /*User::select('users.nameUser', 'categories.nameCategory')
                ->join('categories', 'users.idUser', '=', 'categories.user_id')
                ->get();*/

        return ["cod"=>"00",
        "msg"=>"todo correcto",
        "pagina_actual"=>$pag,
        "cantidad_paginas"=>$c_paginas,
        "datos"=>$query->get()];
    }

    public static function obtener_concepto_punto($id){
       $query = concepto_punto::select("concepto_punto.id","concepto_punto.descripcion", "concepto_punto.puntos_requeridos")
       ->where("concepto_punto.id","=",$id);
       
        return ["cod"=>"00",
        "msg"=>"todo correcto",
        "datos"=>$query->get()];
    }



    public function nuevo(Request $peticion){

        try {
            $campos = $this->validate($peticion,[
                'descripcion'=>'required|string',
                'puntos_requeridos'=>'required|integer'
            ]);
            $concepto_punto = concepto_punto::create($campos);
        } catch (\Illuminate\Validation\ValidationException $e){
            return ["cod"=>"06","msg"=>"Error al insertar los datos","errores"=>[$e->errors() ]];
        }
        catch (\Exception $e) {
            return ["cod"=>"05","msg"=>"Error al insertar los datos"];
        }
        return ["cod"=>"00","msg"=>"todo correcto"];

    }

    public function modificar(Request $peticion,$id){
        try {
            $campos = $this->validate($peticion,[
                'descripcion'=>'required|string',
                'puntos_requeridos'=>'required|integer'
            ]);
            $concepto_punto = concepto_punto::where("id",$id);
            $concepto_punto->update($campos);
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
            $usuario = concepto_punto::where("id",$id);
            $usuario->delete();

            return ["cod"=>"00","msg"=>"todo correcto"];
        } catch (\Exception $e) {
            return ["cod"=>"08","msg"=>"Error al eliminar el registro","errores"=>[$e->getMessage() ]];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\concepto_punto  $concepto_punto
     * @return \Illuminate\Http\Response
     */
    public function show(concepto_punto $concepto_punto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\concepto_punto  $concepto_punto
     * @return \Illuminate\Http\Response
     */
    public function edit(concepto_punto $concepto_punto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\concepto_punto  $concepto_punto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, concepto_punto $concepto_punto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\concepto_punto  $concepto_punto
     * @return \Illuminate\Http\Response
     */
    public function destroy(concepto_punto $concepto_punto)
    {
        //
    }
}
