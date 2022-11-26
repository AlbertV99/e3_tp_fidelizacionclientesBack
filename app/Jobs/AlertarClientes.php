<?php

namespace App\Jobs;

class AlertarClientes extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $dias = 7;
        $fecha_actual= date("Y-m-d");
        $calculo_fecha = date("Y-m-d",strtotime($fecha_actual."+ ".$dias." days"));
        $query = bolsas_punto::select("bolsas_punto.id","cliente.nombre","cliente.apellido","cliente.nro_doc", "bolsas_punto.fecha_asignacion", "bolsas_punto.fecha_caducidad", "bolsas_punto.puntaje_asignado", "bolsas_punto.puntaje_utilizado", "bolsas_punto.puntos_saldo", "bolsas_punto.monto_saldo")
        ->join("cliente","cliente.id", "bolsas_punto.id_cliente")
        -> where("fecha_caducidad", $calculo_fecha);
        $bolsa_vencer = $query ->get();
        foreach ($bolsa_vencer as $key => $value) {
            $email+= ($value->mail);
            $nombre+= ($value->nombre)." ".($value->apellido);
        }
    }
}
