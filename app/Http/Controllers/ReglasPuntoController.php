<?php

namespace App\Http\Controllers;
use App\Models\reglas_punto;
use Illuminate\Http\Request;

class ReglasPuntoController extends Controller
{
      // private $c_reg_lista = env('CANT_VALORES_PANEL');
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public static function listarPanel($pag=0,$busqueda=""){
        $c_reg_panel = env('CANT_VALORES_PANEL');
        $c_paginas = ceil(reglas_punto::count()/$c_reg_panel);
        $salto = $pag*$c_reg_panel;
        $query = reglas_punto::select("reglas_punto.id","reglas_punto.limite_inferior","reglas_punto.limite_superior","reglas_punto.monto_equivalencia","dias_vencimiento");

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
                'limite_inferior'=>'required|integer',
                'limite_superior'=>'required|integer',
                'monto_equivalencia'=>'required|integer',
                'dias_vencimiento'=>'required|integer'
            ]);
            if($campos ['limite_inferior'] > $campos ['limite_superior'] ){
                throw new Exception('Limite inferior debe ser menor al limite superior');
            }
            $reglas_punto = reglas_punto::create($campos);
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
                'limite_inferior'=>'required|integer',
                'limite_superior'=>'required|integer',
                'monto_equivalencia'=>'required|integer'
            ]);
            if($campos ['limite_inferior'] > $campos ['limite_superior'] ){
                throw new Exception('Limite inferior debe ser menor al limite superior');
            }

            $reglas_punto = reglas_punto::where("id",$id);
            $reglas_punto->update($campos);
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
            $usuario = reglas_punto::where("id",$id);
            $usuario->delete();

            return ["cod"=>"00","msg"=>"todo correcto"];
        } catch (\Exception $e) {
            return ["cod"=>"08","msg"=>"Error al eliminar el registro","errores"=>[$e->getMessage() ]];
        }
    }


    public static function devolverpunto ($monto){
        $monto_equivalente = reglas_punto::select("monto_equivalencia")
        ->where("reglas_punto.limite_inferior" , '<=', $monto)
        ->where("reglas_punto.limite_superior" , '>=', $monto)
        ->first ();
        $punto_retorno = intval($monto/intval($monto_equivalente -> monto_equivalencia));



        return ["cod"=>"00",
        "msg"=>"todo correcto",
        "puntaje_asignado"=>$punto_retorno];

    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\cliente  $reglas_punto
     * @return \Illuminate\Http\Response
     */
    public function show(cliente $reglas_punto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\cliente  $reglas_punto
     * @return \Illuminate\Http\Response
     */
    public function edit(cliente $reglas_punto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\cliente  $reglas_punto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, cliente $reglas_punto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\cliente  $reglas_punto
     * @return \Illuminate\Http\Response
     */
    public function destroy(cliente $reglas_punto)
    {
        //
    }
}
