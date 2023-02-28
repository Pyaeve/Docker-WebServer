<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use DB;
use App\Vendedores;
use Auth;
use App\User;
class VendedoresController extends Controller
{
    public function CargarWeb(){
        $user=User::findOrFail(Auth::user()->id);
       
        if($user->hasRole('Developer')){
            $agencias = DB::select("CALL PRO_LISTAR_AGENCIAS('0');");
            $agencias_array=array();

            foreach ($agencias as $node) {
             $agencias_array[$node->ID]=$node->AGENCIA;
            }

            $pos = DB::select("CALL PRO_LISTAR_POS('0');");
            $pos_array = array();
            foreach ($pos as $node) {
             $pos_array[$node->ID]=$node->ID.' - '.$node->IMEI;
            }

             return view('admin.vendedores.cargar',['agencias'=>$agencias_array,'pos'=>$pos_array]);
        }elseif($user->hasRole('Agente')){
            $agencias = DB::select("CALL PRO_LISTAR_AGENCIAS_X_USUARIO_ID('".Auth::user()->id."');");
            $agencias_array=array();

            foreach ($agencias as $node) {
             $agencias_array[$node->ID]=$node->AGENCIA;
            }
             $pos = DB::select("CALL PRO_LISTAR_POS('0');");
            $pos_array = array();
            foreach ($pos as $node) {
             $pos_array[$node->ID]=$node->ID.' - '.$node->IMEI;
            }
            return view('admin.vendedores.cargar',['agencias'=>$agencias_array,'pos'=>$pos_array]);
        }  
    }

   // gusardar
   public function GuardarWeb(Request $req){
        $data = $req->all();

       // dd($data);
        $ciudad = DB::select("SELECT FNC_DAME_CIUDAD_ID_X_AGENCIA_ID('".$data['agencia_id']."') AS 'CIUDAD_ID';");
        $zona = DB::select("SELECT FNC_DAME_ZONA_ID_X_AGENCIA_ID('".$data['agencia_id']."') AS 'ZONA_ID';");
       

        $vendedor = new Vendedores();
        $vendedor->nombre= $data['nombre'];
        $vendedor->apellido= $data['apellido'];
        $vendedor->ci= $data['ci'];
        $vendedor->contacto= $data['contacto'];
        $vendedor->agencia_id= $data['agencia_id'];
        $vendedor->ciudad_id=$ciudad[0]->CIUDAD_ID;
        $vendedor->zona_id=$zona[0]->ZONA_ID;
        $vendedor->supervisor_id=0;
        $vendedor->usuario_id=0;
        $vendedor->pos_id=$data['pos_id'];
        $vendedor->save();
        
        $user=User::create([
            'name' => $data['nombre'],
            'sername' => $data['apellido'],
            'email' => $data['email'],
            'role'=> $data['role'],
            'password' => Hash::make($data['password']),
            'password_text'=>$data['password'],
            'activation_code'=>str_random(20),
            'activation_status'=>0
        ]);
        $user->assignRole($data['role']);
   
        
        $vendedor->usuario_id=$user->id;
        $vendedor->update();
        return redirect(route('backend.vendedores.resumen'));
   }

   // editar
   public function EditarWeb($id){
      $vendedor = Vendedores::find($id);
      $agencias = DB::select("CALL PRO_LISTAR_AGENCIAS('0');");
      $agencias_array=array();

      foreach ($agencias as $node) {
         $agencias_array[$node->ID]=$node->AGENCIA;
      }
      //dd($vendedor);
      return view('admin.vendedores.editar',['data'=>$vendedor,'agencias'=>$agencias_array]);
   }
   

    
     // actualizar
   public function ActualizarWeb(Request $req){
        $data = $req->all();
        //dd($data);

        $vendedor = Vendedores::find($data['vendedor_id']);
        $vendedor->nombre= $data['nombre'];
        $vendedor->apellido= $data['apellido'];
        $vendedor->ci= $data['ci'];
        $vendedor->contacto= $data['contacto'];
        $vendedor->agencia_id= $data['agencia_id'];
        $vendedor->ciudad_id=$data['ciudad_id'];
        $vendedor->zona_id=$data['zona_id'];
         $vendedor->domicilio=$data['domicilio'];
        $vendedor->update();
    //  $vendedor->
        //crear el Vendedor
        //crear el Usuarios 
        //asginarle el Role de Vendedor
        //asignarle un Usuario para Autentica la Venta en la App

        return redirect(route('backend.vendedores.resumen'));

   }
   public function ResumenWeb(){
     $user=User::findOrFail(Auth::user()->id);

        if($user->hasRole('Developer')){
               $data = DB::select("CALL PRO_LISTAR_VENDEDORES('2');");
                return view('admin.vendedores.resumen',['data'=>$data]);
        }elseif ($user->hasRole('Agente')) {
            // code...
            $agencia = DB::select("SELECT FNC_DAME_AGENCIA_ID_X_USUARIO_ID('".Auth::user()->id."') AS 'AGENCIA_ID'");
            $agencia=$agencia[0]->AGENCIA_ID;
            $data = DB::select("CALL PRO_LISTAR_VENDEDORES_X_AGENCIA('".$agencia."','2')");
                return view('admin.vendedores.resumen',['data'=>$data]);
        }    
    
      
   }

   public function VerResumenApi($vendedor,$fecha){

     $data = DB::select("CALL PRO_VER_RESUMEN_RIFAS_X_VENDEDOR('".$vendedor."','".$fecha."');");
     return $data;
   }

   public function VerCajaApi($vendedor,$fecha){
     $data = DB::select("CALL PRO_VER_RESUMEN_CAJA_X_VENDEDOR('".$vendedor."','".$fecha."');");
     return $data;
   }

   public function VerCajaRangoApi($vendedor,$desde,$hasta){
     $data = DB::select("CALL PRO_VER_RESUMEN_CAJA_X_VENDEDOR_RANGO('".$vendedor."','".$desde."','".$hasta."');");
     return $data;
   }

}
