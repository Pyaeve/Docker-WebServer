<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Agencias;
use App\Users;
use App\Agentes;
//AgenciasController
class AgenciasController extends Controller
{
   // cargar
   function CargarWeb(){
      $zonas = DB::select("CALL PRO_LISTAR_ZONAS('0');");
      $zonas_array=array();

      foreach ($zonas as $node) {
         $zonas_array[$node->ID]=$node->ZONA;
      }
      $ciudades = DB::select("CALL PRO_LISTAR_CIUDADES('0');");
      $ciudades_array=array();

      foreach ($ciudades as $node) {
         $ciudades_array[$node->ID]=$node->CIUDAD;
      }
      return view('admin.agencias.cargar',['zonas'=>$zonas_array,'ciudades'=>$ciudades_array]);
    }

   // guardar
   function GuardarWeb(Request $req){
        $data = $req->all();
        
        //dd($data);
        $agencia = new Agencias();
        $agencia->zona_id = $data['zona_id'];
        $agencia->ciudad_id = $data['ciudad_id'];
        $agencia->nombre = $data['nombre'];
        $agencia->ruc = $data['ruc'];
        $agencia->email = $data['email'];
        $agencia->contacto = $data['contacto'];
        $agencia->domicilio = $data['domicilio'];
        $agencia->save();
        return redirect(route('backend.agentes.cargar'));

   }

   //actualizar
    function ActualizarWeb(Request $req){
        $data = $req->all();
        dd($data);
   }

   // editar
    function EditarWeb($id){
      $agencia = Agencias::find($id);
      
      $zonas = DB::select("CALL PRO_LISTAR_ZONAS('0');");
      $zonas_array=array();
      foreach ($zonas as $node) {
         $zonas_array[$node->ID]=$node->ZONA;
      }

      $ciudades = DB::select("CALL PRO_LISTAR_CIUDADES('0');");
      $ciudades_array=array();
      foreach ($ciudades as $node) {
         $ciudades_array[$node->ID]=$node->CIUDAD;
      }

      return view('admin.agencias.editar',['data'=>$agencia,'zonas'=>$zonas_array,'ciudades'=>$ciudades_array]);
   }

   

   // resumen
   function ResumenWeb(){
       $data = DB::select("CALL PRO_LISTAR_AGENCIAS('2');");
       return view('admin.agencias.resumen',['data'=>$data]);
   }


   function BorrarWewb($id){
      $agencia = Agencias::find($id);
    

      
   }

 

   
}
