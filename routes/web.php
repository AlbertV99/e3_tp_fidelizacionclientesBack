<?php

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

$router->get('/listar/bolsapuntos', function () use ($router) {
    return "LISTAR BOLSA";
});
$router->get('/listar/reglaspunto/{pag}', ['uses'=>'ReglasPuntoController@listarPanel']);

$router->get('/listar/usopunto/{pag}', ['uses'=>'UsoPuntoCabController@listarPanel']);




//INSERCION DE DATOS
$router->post('/nuevo/cliente', ['uses'=>'ClienteController@nuevo']);
$router->post('/nuevo/punto', ['uses'=>'ConceptoPuntoController@nuevo']);
$router->post('/nuevo/bolsa', function () use ($router) {
    return "NUEVA BOLSA";
});
$router->post('/nuevo/reglaspunto', ['uses'=>'ReglasPuntoController@nuevo']);
$router->post('/nuevo/usopunto', ['uses'=>'UsoPuntoCabController@nuevo']);



//MODIFICACION DE DATOS
$router->put('/modif/cliente/{id}', ['uses'=>'ClienteController@modificar']);
$router->put('/modif/punto/{id}', ['uses'=>'ConceptoPuntoController@modificar']);
$router->put('/modif/bolsa', function () use ($router) {
    return "MODIF BOLSA";
});
$router->put('/modif/reglaspunto/{id}', ['uses'=>'ReglasPuntoController@modificar']);




//ELIMINACION DE DATOS
$router->delete('/eliminar/cliente/{id}', ['uses'=>'ClienteController@eliminar']);
$router->delete('/eliminar/punto', function () use ($router) {
    return "ELIMINAR PUNTO ";
});
$router->delete('/eliminar/bolsa', function () use ($router) {
    return "ELIMINAR BOLSA";
});
$router->delete('/eliminar/reglaspunto', ['uses'=>'ReglasPuntoController@listarPanel']);
