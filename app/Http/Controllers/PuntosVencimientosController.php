<?php

namespace App\Http\Controllers;

use App\Models\puntos_vencimientos;
use Illuminate\Http\Request;
//'fecha_inicio','fecha_fin','duracion'
class PuntosVencimientosController extends Controller
{
    public static function listarPanel($pag=0,$busqueda=""){
        $c_reg_panel = env('CANT_VALORES_PANEL');
        $c_paginas = ceil(puntos_vencimientos::count()/$c_reg_panel);
        $salto = $pag*$c_reg_panel;
        $query = puntos_vencimientos::select("puntos_vencimiento.id","puntos_vencimiento.fecha_inicio", "puntos_vencimiento.fecha_fin", "puntos_vencimiento.duracion");

        /*User::select('users.nameUser', 'categories.nameCategory')
                ->join('categories', 'users.idUser', '=', 'categories.user_id')
                ->get();*/

        return ["cod"=>"00",
        "msg"=>"todo correcto",
        "pagina_actual"=>$pag,
        "cantidad_paginas"=>$c_paginas,
        "datos"=>$query->get()];
    }
    public static function obtener_vencimiento_punto($id){
        $query = puntos_vencimientos::select("puntos_vencimiento.id","puntos_vencimiento.fecha_inicio", "puntos_vencimiento.fecha_fin", "puntos_vencimiento.duracion")
        ->where("puntos_vencimiento.id","=",$id);

        /*User::select('users.nameUser', 'categories.nameCategory')
                ->join('categories', 'users.idUser', '=', 'categories.user_id')
                ->get();*/

        return ["cod"=>"00",
        "msg"=>"todo correcto",
        "datos"=>$query->get()];
    }


    public function nuevo(Request $peticion){

        try {
            $campos = $this->validate($peticion,[
                'fecha_inicio'=>'required|date',
                'fecha_fin'=>'required|date',
                'duracion'=>'required|integer'
            ]);
            $puntos_vencimientos = puntos_vencimientos::create($campos);
        } catch (\Illuminate\Validation\ValidationException $e){
            return ["cod"=>"06","msg"=>"Error al insertar los datos","errores"=>[$e->errors() ]];
        }
        catch (\Exception $e) {
            return ["cod"=>"05","msg"=>"Error al insertar los datos","errores"=>[$e->getMessage() ]];
        }
        return ["cod"=>"00","msg"=>"todo correcto"];

    }

    public function modificar(Request $peticion,$id){
        try {
            $campos = $this->validate($peticion,[
                'fecha_inicio'=>'required|date',
                'fecha_fin'=>'required|date',
                'duracion'=>'required|integer'
            ]);
            $puntos_vencimientos = puntos_vencimientos::where("id",$id);
            $puntos_vencimientos->update($campos);
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
            $usuario = puntos_vencimientos::where("id",$id);
            $usuario->delete();

            return ["cod"=>"00","msg"=>"todo correcto"];
        } catch (\Exception $e) {
            return ["cod"=>"08","msg"=>"Error al eliminar el registro","errores"=>[$e->getMessage() ]];
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\puntos_vencimientos  $puntos_vencimientos
     * @return \Illuminate\Http\Response
     */
    public function show(puntos_vencimientos $puntos_vencimientos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\puntos_vencimientos  $puntos_vencimientos
     * @return \Illuminate\Http\Response
     */
    public function edit(puntos_vencimientos $puntos_vencimientos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\puntos_vencimientos  $puntos_vencimientos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, puntos_vencimientos $puntos_vencimientos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\puntos_vencimientos  $puntos_vencimientos
     * @return \Illuminate\Http\Response
     */
    public function destroy(puntos_vencimientos $puntos_vencimientos)
    {
        //
    }
}
