<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Agentes;
use DB;
use App\User;
class AgentesController extends Controller
{
     // cargar
   function CargarWeb(){

 $agencias = DB::select("CALL PRO_LISTAR_AGENCIAS('0');");
      $agencias_array=array();

      foreach ($agencias as $node) {
         $agencias_array[$node->ID]=$node->AGENCIA;
      }
     
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
        return view('admin.agentes.cargar',['agencias'=>$agencias_array,'zonas'=>$zonas_array,'ciudades'=>$ciudades_array]);
    }

   // guardar
   function GuardarWeb(Request $req){
        $data = $req->all();
      
        $ciudad = DB::select("SELECT FNC_DAME_CIUDAD_ID_X_AGENCIA_ID('".$data['agencia_id']."') AS 'CIUDAD_ID';");
        $zona = DB::select("SELECT FNC_DAME_ZONA_ID_X_AGENCIA_ID('".$data['agencia_id']."') AS 'ZONA_ID';");
        $user=User::create([
            'name' => $data['nombre'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'password_text'=>$data['password'],
        ]);
        $user->assignRole('Developer');
        $agente = new Agentes();
        $agente->agencia_id = $data['agencia_id'];
        $agente->usuario_id=$user->id;
        $agente->zona_id=$zona[0]->ZONA_ID;
        $agente->nombre = $data['nombre'];
        $agente->ciudad_id=$ciudad[0]->CIUDAD_ID;
        $agente->apellido = $data['apellido'];
        $agente->email = $data['email'];
        $agente->contacto = $data['contacto'];
        $agente->domicilio = $data['domicilio'];
        $agente->save();
        return redirect(route('backend.agentes.resumen'));
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

      return view('admin.agentes.editar',['data'=>$agencia,'zonas'=>$zonas_array,'ciudades'=>$ciudades_array]);
   }

   

   // resumen
   function ResumenWeb(){
       $data = DB::select("CALL PRO_LISTAR_AGENTES('2');");
       return view('admin.agentes.resumen',['data'=>$data]);
   }


   function BorrarWewb($id){
      $agencia = Agencias::find($id);
    
   }
}
