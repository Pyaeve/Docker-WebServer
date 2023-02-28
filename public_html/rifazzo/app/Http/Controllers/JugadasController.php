<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Jugadas;
use Carbon\Carbon;
use App\Asignados;
use Auth;
use App\User;
class JugadasController extends Controller
{
    //
    function CargarWeb(){
     $user  = Auth::user();
     $agencias=[];
     if($user->hasRole('Developer')){
        $agencias = DB::select("CALL PRO_LISTAR_AGENCIAS('0');");
        $agencias_array=array();
    }elseif($user->hasRole('Supervisor')){
        $agencias = DB::select("CALL PRO_LISTAR_AGENCIAS_X_USUARIO_ID('".$user->id."');");
        $agencias_array=array();

     
     }elseif($user->hasRole('Agente')){
        $agencias = DB::select("CALL PRO_LISTAR_AGENCIAS_X_USUARIO_ID('".$user->id."');");
        $agencias_array=array();

     }
     
      foreach ($agencias as $node) {
         $agencias_array[$node->ID]=$node->AGENCIA;
      }

      $modalidades = DB::select("CALL PRO_LISTAR_MODALIDADES('1');");
      $modalidades_array = array();
      foreach($modalidades as $node){
        $modalidades_array[$node->ID]=$node->MODALIDAD;
      }

      return view('admin.jugadas.cargar',['agencias'=>$agencias_array,'modalidades'=>$modalidades_array]);
    } 

    function GuardarWeb(Request $req){
        $data = $req->all();
        //dd($data);
        $ciudad = DB::select("SELECT FNC_DAME_CIUDAD_ID_X_AGENCIA_ID('".$data['agencia_id']."') AS 'CIUDAD_ID';");
        $zona = DB::select("SELECT FNC_DAME_ZONA_ID_X_AGENCIA_ID('".$data['agencia_id']."') AS 'ZONA_ID';");
        $jugada = new Jugadas();
        $jugada->agencia_id=$data['agencia_id'];
        $jugada->modalidad_id=$data['modalidad_id'];
        $jugada->fecha = $data['fecha'];
        $jugada->zona_id=$zona[0]->ZONA_ID;
        $jugada->ciudad_id=$ciudad[0]->CIUDAD_ID;
        $jugada->nro_desde = $data['nro_desde'];
        $jugada->nro_hasta = $data['nro_hasta'];
        $jugada->precio=$data['precio'];
        $jugada->comision=$data['comision'];
        $jugada->premio_1=$data['premio1'];
        $jugada->premio_2=$data['premio2'];
        $jugada->premio_3=$data['premio3'];
        $jugada->estado=1;
        $jugada->save();

        
        $jugada_anterior = Jugadas::find($jugada->id-1);
        if(!is_null($jugada_anterior)){
            if($jugada_anterior->modalidad_id=$data['modalidad_id']){
                 $jugada_anterior->estado=2;
                 $jugada_anterior->update();
            }
           

        }
       
      
         return redirect(route('backend.jugadas.resumen'));
    }

    
    function ResumenWeb(){
        $user = User::findOrFail(Auth::user()->id);
        $agencia = DB::select("SELECT FNC_DAME_AGENCIA_ID_X_USUARIO_ID('".$user->id."') AS 'AGENCIA_ID';");
        $agencia = $agencia[0]->AGENCIA_ID;
        $jugadas = DB::select("CALL PRO_LISTAR_JUGADAS('".$agencia."');");
        return view('admin.jugadas.resumen',['data'=>$jugadas]);


    }

    function AjaxDameJugadaXModalidad($modalidad,$agencia){
        $jugada_id = DB::select("SELECT FNC_DAME_JUGADA_ID_X_MODALIDAD_ID('".$modalidad."') AS JUGADA_ID");
        $jugada_id = $jugada_id[0]->JUGADA_ID;
        $jugada_fecha = DB::select("SELECT FNC_DAME_JUGADA_FECHA('".$jugada_id."') AS JUGADA_FECHA");
        $jugada_fecha = $jugada_fecha[0]->JUGADA_FECHA;
        $res = [];
        $res[0]['JUGADA_ID']=$jugada_id;
        $res[0]['JUGADA_FECHA']=$jugada_fecha;
        return $res;

    }


    //ver jugada x modalidad
    function VerJugadaXModalidadAPI($modalidad,$agencia){
        //obtengo la jugada activa segun la modalidad y la agencia
        $jugada_id = DB::select("SELECT FNC_DAME_JUGADA_ID_X_MODALIDAD_ID('".$modalidad."','".$agencia."') AS 'JUGADA_ID';");
        $jugada_id=$jugada_id[0]->JUGADA_ID;
        //obtenkos los datos de esa jugda en particular
        $data = DB::select("CALL PRO_DAME_JUGADA_DATOS('".$jugada_id."');");
        return $data;

    }
}