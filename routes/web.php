<?php
use App\Models\bolsas_punto;

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return "albert test";
});

//LISTAS DESPLEGABLES
$router->get('/listar/nacionalidad[/{busqueda}]', ['uses'=>'NacionalidadController@listaDesplegable']);


//LISTAR DATOS
$router->get('/listar/cliente/{pag}', ['uses'=>'ClienteController@listarPanel']);

$router->get('/listar/conceptopuntos/{pag}', ['uses'=>'ConceptoPuntoController@listarPanel']);

$router->get('/listar/vencimientopuntos/{pag}', ['uses'=>'PuntosVencimientosController@listarPanel']);

$router->get('/listar/reglaspunto/{pag}', ['uses'=>'ReglasPuntoController@listarPanel']);

$router->get('/listar/bolsaspunto/{pag}', ['uses'=>'BolsasPuntoController@listarPanel']);

$router->get('/listar/usopunto/{pag}', ['uses'=>'UsoPuntoCabController@listarPanel']);

$router->get('/listar/reglasorteo/{pag}', ['uses'=>'ReglaSorteoController@listarPanel']);

$router->get('/listar/usuario/nombre/{nom}/pass/{pass}', ['uses'=>'UsuarioController@validarUsuarioUnico']);

////LISTAR DATOS
$router->get('/obtener/cliente/{id}', ['uses'=>'ClienteController@obtener_cliente']);

$router->get('/obtener/conceptopuntos/{id}', ['uses'=>'ConceptoPuntoController@obtener_concepto_punto']);

$router->get('/obtener/vencimientopuntos/{id}', ['uses'=>'PuntosVencimientosController@obtener_vencimiento_punto']);

$router->get('/obtener/reglaspunto/{id}', ['uses'=>'ReglasPuntoController@obtener_regla_punto']);

$router->get('/obtener/reglasorteo/{id}', ['uses'=>'ReglaSorteoController@obtener_regla_sorteo']);



//$router->get('/listar/usuario', ['uses'=>'UsuarioController@validarUsuarioUnico']);


//INSERCION DE DATOS
$router->post('/nuevo/cliente', ['uses'=>'ClienteController@nuevo']);

$router->post('/nuevo/punto', ['uses'=>'ConceptoPuntoController@nuevo']);

$router->post('/nuevo/vencimientopunto', ['uses'=>'PuntosVencimientosController@nuevo']);

$router->post('/nuevo/bolsa', function () use ($router) {
    return "NUEVA BOLSA";
});
$router->post('/nuevo/reglaspunto', ['uses'=>'ReglasPuntoController@nuevo']);

$router->post('/nuevo/bolsaspunto', ['uses'=>'BolsasPuntoController@nuevo']);

$router->post('/nuevo/usopunto', ['uses'=>'UsoPuntoCabController@nuevo']);

$router->post('/nuevo/reglasorteo', ['uses'=>'ReglaSorteoController@nuevo']);

//MODIFICACION DE DATOS
$router->put('/modif/cliente/{id}', ['uses'=>'ClienteController@modificar']);

$router->put('/modif/punto/{id}', ['uses'=>'ConceptoPuntoController@modificar']);

$router->put('/modif/vencimientopunto/{id}', ['uses'=>'PuntosVencimientosController@modificar']);

$router->put('/modif/bolsa', function () use ($router) {
    return "MODIF BOLSA";
});
$router->put('/modif/reglaspunto/{id}', ['uses'=>'ReglasPuntoController@modificar']);

$router->put('/modif/bolsaspunto/{id}', ['uses'=>'BolsasPuntoController@modificar']);

$router->put('/modif/reglasorteo/{id}', ['uses'=>'ReglaSorteoController@modificar']);






//ELIMINACION DE DATOS
$router->delete('/eliminar/cliente/{id}', ['uses'=>'ClienteController@eliminar']);

$router->delete('/eliminar/punto/{id}', ['uses'=>'ConceptoPuntoController@eliminar']);

$router->delete('/eliminar/vencimientopunto/{id}', ['uses'=>'PuntosVencimientosController@eliminar']);

$router->delete('/eliminar/bolsa', function () use ($router) {
    return "ELIMINAR BOLSA";
});
$router->delete('/eliminar/reglaspunto/{id}', ['uses'=>'ReglasPuntoController@eliminar']);

$router->delete('/eliminar/bolsaspunto/{id}', ['uses'=>'BolsasPuntoController@eliminar']);

$router->delete('/eliminar/reglasorteo/{id}', ['uses'=>'ReglaSorteoController@eliminar']);


//REPORTES
$router->get('/reporte/bolsaspunto/inf/{rango_inferior}/sup/{rango_superior}', ['uses'=>'BolsasPuntoController@listar_bolsa_punto_rango']);
$router->get('/reporte/bolsapuntos/{id}', ['uses'=>'BolsasPuntoController@listar_bolsa_punto_cliente']);
$router->get('/reporte/reglaspunto/{monto}', ['uses'=>'ReglasPuntoController@devolverpunto']);
$router->get('/reporte/usopuntocab/cli/{id}', ['uses'=>'UsoPuntoCabController@listarusopuntoid']);
$router->get('/reporte/usopuntocab/concep/{concepto}', ['uses'=>'UsoPuntoCabController@listarusopuntoconcepto']);
$router->get('/reporte/usopuntocab/fech/{fecha}', ['uses'=>'UsoPuntoCabController@listarusopuntofecha']);
$router->get('/reporte/cliente/{dias}', ['uses'=>'ClienteController@listar_cliente_vencido']);
$router->get('/reporte/cliente/nombre/{nombre}', ['uses'=>'ClienteController@listar_cliente_nombre']);
$router->get('/reporte/cliente/apellido/{apellido}', ['uses'=>'ClienteController@listar_cliente_apellido']);
$router->get('/reporte/cliente/cumple/{cumpleanos}', ['uses'=>'ClienteController@listar_cliente_cumple']);

//SERVICIO
$router->post('/servicio/cargapuntos', ['uses'=>'BolsasPuntoController@cargapuntos']);

$router->get('/servicio/mail',function () {
    $direcciones = [];
    $dias = 7;
    $fecha_actual= date("Y-m-d");
    $calculo_fecha = date("Y-m-d",strtotime($fecha_actual."+ ".$dias." days"));
    $query = bolsas_punto::select("bolsas_punto.id","cliente.nombre","cliente.apellido","cliente.mail")
    ->join("cliente","cliente.id", "bolsas_punto.id_cliente")
    -> where("fecha_caducidad", $calculo_fecha);
    $bolsa_vencer = $query ->get();
    foreach ($bolsa_vencer as $key => $value) {
        $email = ($value->mail);
        $nombre = ($value->nombre)." ".($value->apellido);
        $direcciones[] = [$email, $nombre];
        App\Http\Controllers\Email::mail("mailtest", $email, "Alerta de puntos a vencer",["name"=>$nombre, "days"=>$dias]);

    }
    return response()->json($direcciones);
    // return view('ganador', ['name' => 'Tio Cosa', 'descripcion' =>'Ghost']);
});
$router->get('/servicio/enviarmail',function () {
    App\Http\Controllers\Email::mail("mailtest","yannyhemmings@fpuna.edu.py","prueba mail",["name"=>"Coso", "days"=>"7"]);
    return ["msg"=>"enviado"];
});
