<?php

namespace App\Http\Controllers;

use App\Models\Nacionalidad;
use Illuminate\Http\Request;

class NacionalidadController extends Controller{
    public static function listaDesplegable($busqueda=""){
        $c_reg_lista = env('CANT_VALORES_LISTA');
        $query = Nacionalidad::select("nacionalidad.id","nacionalidad.nacionalidad")->limit($c_reg_lista);

        /*User::select('users.nameUser', 'categories.nameCategory')
                ->join('categories', 'users.idUser', '=', 'categories.user_id')
                ->get();*/

        return ["cod"=>"00",
        "msg"=>"todo correcto",
        "datos"=>$query->get()];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function nuevoJob(String $nNacionalidad){
         try {
             $nacionalidad = Nacionalidad::create(["nacionalidad"=>$nNacionalidad]);
             return ["cod"=>"00","msg"=>"todo correcto"];
         } catch (\Illuminate\Validation\ValidationException $e){
             return ["cod"=>"06","msg"=>"Error al insertar los datos","errores"=>[$e->errors() ]];
         }
         catch (\Exception $e) {
             return ["cod"=>"05","msg"=>"Error al insertar los datos","errores"=>[$e->getMessage() ]];
         }
     }
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
     * @param  \App\Models\Nacionalidad  $nacionalidad
     * @return \Illuminate\Http\Response
     */
    public function show(Nacionalidad $nacionalidad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Nacionalidad  $nacionalidad
     * @return \Illuminate\Http\Response
     */
    public function edit(Nacionalidad $nacionalidad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Nacionalidad  $nacionalidad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Nacionalidad $nacionalidad)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Nacionalidad  $nacionalidad
     * @return \Illuminate\Http\Response
     */
    public function destroy(Nacionalidad $nacionalidad)
    {
        //
    }
}
