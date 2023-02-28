<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/usuarios/login/{email}/{pass}', 'UsuariosController@LoginUsuario');
//Rifas
Route::post('/rifas/vender','RifasController@VenderRifaApi')->name('api.rifas.vender');
Route::get('/rifas/generar/{vendedor}/{modalidad}/{agencia}','RifasController@GenerarNroRifaApi')->name('api.rifas.generar');
Route::get('/rifas/asignar/nro/{vendedor}/{rifa}','RifasController@AsignarNroRifaApi')->name('api.rifas.asignar');

Route::get('/rifas/ventas/agencia/7dias/{agencia}','RifasController@VerRifasVendidasXAgenciaApi')->name('api.rifas.ventas.agencia');


//Vendedores
Route::get('/vendedores/resumen/{vendedor}/{fecha}','VendedoresController@VerResumenApi')->name('api.vendedores.resumen');

Route::get('/vendedores/caja/{vendedor}/{fecha}','VendedoresController@VerCajaApi')->name('api.vendedores.caja');

Route::get('/vendedores/caja/rango/{vendedor}/{desde}/{hasta}','VendedoresController@VerCajaRangoApi')->name('api.vendedores.caja.rango');


//Sorteos registrar
Route::get('sorteos/registrar/{agencia}/{jugada}/{rifa}','SorteosController@RegistarRifaNroAPI');
//Sorteos listaar
Route::get('sorteos/listar/{agencia}/{fecha}','SorteosController@ListarSorteosAPI');

Route::get('rifas/verificar/{rifa}/{token}','SorteosController@VerificarRifaAPI');
/*Sorteos registrar
Route::post('sorteos/registrar','SorteosController@RegistarRifaNroSorteadaAPI');*/

//listar Modalidades segun agencia
Route::get('modalidades/{agencia}','ModalidadesController@ListarModalidadesXAgenciaAPI');
//Listar Jugada segun modalidad
Route::get('jugada/modalidad/{modalidad}/{agencia}','JugadasController@VerJugadaXModalidadAPI');
