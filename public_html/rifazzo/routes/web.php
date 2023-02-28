<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return redirect('/backend/home');
});

Auth::routes();

Route::get('/backend/home', 'HomeController@index')->name('home');


//Jugadas
Route::get('/backend/jugadas/cargar','JugadasController@CargarWeb')->name('backend.jugadas.cargar');
Route::post('/backend/jugadas/guardar','JugadasController@GuardarWeb')->name('backend.jugadas.guardar');
Route::post('/backend/jugadas/actualizar','JugadasController@ActualizarWeb')->name('backend.jugadas.actualizar');
Route::get('/backend/jugadas/resumen','JugadasController@ResumenWeb')->name('backend.jugadas.resumen');
Route::get('/backend/jugadas/{id}/editar','JugadasController@EditarWeb')->name('backend.jugadas.editar'); 
Route::get('/backend/jugadas/generar/{vendedor}','JugadasController@GenerarNroRifaWeb')->name('backend.jugadas.generar.rifa');
Route::get('/backend/jugadas/asignar/nro/{vendedor}/{rifa}','JugadasController@AsignarNroRifaWeb')->name('backend.jugadas.asignar.rifa');
Route::get('/backend/jugadas/modalidad/{modalidad}','JugadasController@AjaxDameJugadaXModalidad')->name('backend.jugadas.modadlidad');



//agencias
Route::get('/backend/agencias/cargar','AgenciasController@CargarWeb')->name('backend.agencias.cargar');;
Route::post('/backend/agencias/guardar','AgenciasController@GuardarWeb')->name('backend.agencias.guardar');
Route::post('/backend/agencias/actualizar','AgenciasController@ActualizarWeb')->name('backend.agencias.actualizar');
Route::get('/backend/agencias/resumen','AgenciasController@ResumenWeb')->name('backend.agencias.resumen');
Route::get('/backend/agencias/{id}/editar','AgenciasController@EditarWeb')->name('backend.agencias.editar');    

//agentes
Route::get('/backend/agentes/cargar','AgentesController@CargarWeb')->name('backend.agentes.cargar');;
Route::post('/backend/agentes/guardar','AgentesController@GuardarWeb')->name('backend.agentes.guardar');
Route::post('/backend/agentes/actualizar','AgentesController@ActualizarWeb')->name('backend.agentes.actualizar');
Route::get('/backend/agentes/resumen','AgentesController@ResumenWeb')->name('backend.agentes.resumen');
Route::get('/backend/agentes/{id}/editar','AgentesController@EditarWeb')->name('backend.agentes.editar');    


//vendedores
Route::get('/backend/vendedores/cargar','VendedoresController@CargarWeb')->name('backend.vendedores.cargar');;
Route::post('/backend/vendedores/guardar','VendedoresController@GuardarWeb')->name('backend.vendedores.guardar');
Route::post('/backend/vendedores/actualizar','VendedoresController@ActualizarWeb')->name('backend.vendedores.actualizar');
Route::get('/backend/vendedores/resumen','VendedoresController@ResumenWeb')->name('backend.vendedores.resumen');
Route::get('/backend/vendedores/{id}/editar','VendedoresController@EditarWeb')->name('backend.vendedores.editar');



//zonas
Route::get('/backend/zonas/cargar','ZonasController@CargarWeb')->name('backend.zonas.cargar');
Route::post('/backend/zonas/guardar','ZonasController@GuardarWeb')->name('backend.zonas.guardar');
Route::get('/backend/zonas/resumen','ZonasController@ResumenWeb')->name('backend.zonas.resumen');
Route::get('/backend/zonas/ajax/agencia/{id}','ZonasController@ZonaXAgenciaAjaxWeb')->name('backend.zonas.agencias');


//ciudades

Route::get('/backend/ciudades/ajax/{id}','CiudadesController@ajaxWeb')->name('backend.ciudades.ajax');

//sorteador
Route::get('/sortear',function(){

    return view('admin.jugadas.index');
});



//usuarios
Route::get('/backend/usuarios/cargar','UsuariosController@CargarFormRegistro')->name('backend.usuarios.cargar');

Route::post('/backend/usuarios/guardar','UsuariosController@RegistrarUsuario')->name('backend.usuarios.registrar');

Route::get('backend/usuarios/perfil','UsuariosController@MostrarPerfilWeb')->name('backend.usuarios.perfil');


//rifas

Route::get('/backend/rifas/resumen','RifasController@VerResumenVentasGraficaWeb')->name('backend.rifas.resumen');
Route::get('/backend/rifas/vender','RifasController@MostrarFormVenderRifaWeb')->name('backend.rifas.vender');

Route::post('/backend/rifas/vender','RifasController@VenderRifaWeb')->name('backend.rifas.vender2');


//caja
Route::get('/backend/caja/cargar','CajaController@CargarWeb')->name('backend.caja.cargar');
Route::post('/backend/caja/guardar','CajaController@GuardarWeb')->name('backend.zonas.guardar');
Route::get('/backend/caja/vendedor','CajaController@IndexVendedorCajaWeb')->name('backend.caja.vendedor');
Route::get('/backend/caja/agencia','CajaController@IndexAgenciaCajaWeb')->name('backend.caja.agencia');
Route::get('/backend/caja/resumen/vendedor','CajaController@ResumenCajaVendedorWeb')->name('backend.caja.resumen.vendedor');
Route::get('/backend/caja/resumen/agencia','CajaController@ResumenCajaAgenciaWeb')->name('backend.caja.resumen.agencia');



//sorteos

Route::get('/backend/sorteos/sortear','SorteosController@MostrarSorteadorWeb')->name('backend.sorteos.sortear');
Route::get('/backend/sorteos/cargar','SorteosController@FormCargarSorteoWeb')->name('backend.sorteos.cargar');
Route::post('/backend/sorteos/guardar','SorteosController@GuardarSorteoWeb')->name('backend.sorteos.guardar');
Route::get('/backend/sorteos/resumen','SorteosController@ListarSorteosWeb')->name('backend.sorteos.resumen');


//verificador de rifas
Route::get('/{rifa}/{token}','SorteosController@VerificarRifaWeb');


//POS 
Route::get('/backend/pos/cargar','PosController@FormCargarWeb')->name('backend.pos.cargar');
Route::get('/backend/pos/resumen','PosController@VerResumenWeb')->name('backend.pos.resumen');
Route::post('/backend/pos/guardar','PosController@GuardarWeb')->name('backend.pos.guardar');



//infomres
Route::get('/backend/informes/vendedores','InformesController@VerInformeVendedoresWeb')->name('backend.informes.vendedores');

//utilidades
Route::get('/backend/utilidades/calculadora', 'UtilController@FormCalculadoraRiesgos')->name('backend.util.calculadora');

Route::get('/comentarios',function(){

  /* $columns = \Schema::getColumnListing('agencias');
   foreach ($columns as $n) {
       // code...
       $c = \DB::select("SHOW FULL COLUMNS FROM comments where FIELD='".."'");
   }
   dd($columns);*/

   $tableColumnInfos = \DB::select('SHOW FULL COLUMNS FROM agencias');
   $value = \DB::select('SHOW FULL COLUMNS FROM agencias');
   BootForm::open();
foreach ($tableColumnInfos as $tableColumnInfo) {
  
  /* echo '<br/>'.'<b>Campo: '.$tableColumnInfo->Field . '</b><br/><b>Comentario:</b>' . $tableColumnInfo->Comment.'<br/>'; */
  $_c = $tableColumnInfo->Comment;
  $_a = json_decode($_c);
  switch ($_a['input']) {
      case 'hidden':
          BootForm::hidden($_a['name'])->value($_a[]);
          // code...
          break;
      
      default:
          // code...
          break;
  }
}
echo "</pre>";
 BootForm::close();
});




Route::get('chat','ChatController@chatjs');