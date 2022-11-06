<?php

namespace App\Jobs;
use App\Models\bolsas_punto;

class ActualizarPuntosVencidos extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(){
        // NacionalidadController::nuevoJob("Brasilero");
        // print("testing");
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(){
        // print("Testing job");
        bolsas_punto::where("fecha_caducidad",date("Y-m-d"))->update(["puntos_saldo"=>0]);

    }
}
