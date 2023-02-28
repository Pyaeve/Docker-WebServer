<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class ZonasController extends Controller{

//
    public function cargarWeb(){
        return view('admin.zonas.cargar');
    }

    // gusardar
    public function guardarWeb(Request $req){
        $data = $req->all();
        dd($data);
    }

      public function resumenWeb(){
        $data = DB::select("CALL PRO_LISTAR_ZONAS('0')");
        return view('admin.zonas.resumen',['data'=>$data]);
    }
    public function ZonaXAgenciaAjaxWeb($id){
      $data = DB::select("SELECT FNC_DAME_ZONA_ID_X_AGENCIA_ID('".$id."') AS 'ZONA_ID';");
      return $data;
   }

}
