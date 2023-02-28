<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;
use Auth;
use App\Sorteos;
use App\Jugadas;

class SorteosController extends Controller
{
    //Sortear Jugada

    function MostrarSorteadorWeb(){
        $user = Auth::user();
         $agencia_id = DB::select("SELECT FNC_DAME_AGENCIA_ID_X_USUARIO_ID('".$user->id."')  AS 'AGENCIA_ID'");
         $jugada_id = DB::select("SELECT FNC_DAME_JUGADA_ID_X_AGENCIA_ID('".$agencia_id[0]->AGENCIA_ID."') AS 'JUGADA_ID'");
        $jugada_fecha = DB::select("SELECT FNC_DAME_JUGADA_FECHA('".$jugada_id[0]->JUGADA_ID."') AS 'JUGADA_FECHA'");
      
        $agencia_nombre = DB::select("SELECT FNC_DAME_AGENCIA_NOMBRE('".$agencia_id[0]->AGENCIA_ID."')  AS 'AGENCIA_NOMBRE'");
        $zona_id = DB::select("SELECT FNC_DAME_ZONA_ID_X_AGENCIA_ID('".$agencia_id[0]->AGENCIA_ID."')  AS 'ZONA_ID'");
        $zona_nombre = DB::select("SELECT FNC_DAME_ZONA_NOMBRE('".$zona_id[0]->ZONA_ID."')  AS 'ZONA_NOMBRE'");
        $ciudad_id = DB::select("SELECT FNC_DAME_CIUDAD_ID_X_AGENCIA_ID('".$agencia_id[0]->AGENCIA_ID."')  AS 'CIUDAD_ID'");
        $ciudad_nombre = DB::select("SELECT FNC_DAME_CIUDAD_NOMBRE('".$ciudad_id[0]->CIUDAD_ID."')  AS 'CIUDAD_NOMBRE'");
     
        return view('admin.sorteos.sortear',[
            'jugada_id'=>$jugada_id[0]->JUGADA_ID,'jugada_fecha'=>$jugada_fecha[0]->JUGADA_FECHA,
            'ciudad_id'=>$ciudad_id[0]->CIUDAD_ID,'ciudad_nombre'=>$ciudad_nombre[0]->CIUDAD_NOMBRE,
            'zona_id'=>$zona_id[0]->ZONA_ID,'zona_nombre'=>$zona_nombre[0]->ZONA_NOMBRE,
            'agencia_id'=>$agencia_id[0]->AGENCIA_ID,'agencia_nombre'=>$agencia_nombre[0]->AGENCIA_NOMBRE
        ]

        );
        
    }
    

    function RegistarRifaNroAPI($agencia,$jugada,$rifa){
        $sorteo = new Sorteos();
        $sorteo->fecha = date('Y-m-d');
        $sorteo->hora= date('H:i:s');
        $sorteo->agencia_id = $agencia;
        $sorteo->jugada_id = $jugada;
        $sorteo->rifa_nro = $rifa;
        $res ="Registro de Sorteo con Exito";

        if($sorteo->save()){
            $jugada = Jugadas::find($jugada);
            $jugada->estado=2;
            $jugada->save();
            return $res;
        }

    }

    function RegistarRifaNroSorteadaAPI(Request $req){
        $data = $req->all();
        $sorteo = new Sorteos();
        $sorteo->fecha = date('Y-m-d');
        $sorteo->hora= date('H:i:s');
        $sorteo->agencia_id = $data['agencia_id'];
        $sorteo->jugada_id = $data['jugada_id'];
        $sorteo->rifa_nro = $data['rifa_nro'];
        $sorteo->save();

    }

    function VerificarRifaAPI($rifa,$token){
        $agencia_id = DB::select("SELECT FNC_DAME_AGENCIA_ID_X_RIFA('".$rifa."','".$token."') AS AGENCIA_ID");
        $agencia_id=$agencia_id[0]->AGENCIA_ID;
        $agencia_nombre = DB::select("SELECT FNC_DAME_AGENCIA_NOMBRE('".$agencia_id."') AS AGENCIA_NOMBRE");
        $agencia_nombre=$agencia_nombre[0]->AGENCIA_NOMBRE;
        $jugada_id = DB::select("SELECT FNC_DAME_JUGADA_ID_X_AGENCIA_ID('".$agencia_id."') AS 'JUGADA_ID'");
        $jugada_id=$jugada_id[0]->JUGADA_ID;
        $jugada_fecha = DB::select("SELECT DATE_FORMAT(FNC_DAME_JUGADA_FECHA('".$jugada_id."'), '%W %M %Y') AS 'JUGADA_FECHA';");
       
        $jugada_fecha=$jugada_fecha[0]->JUGADA_FECHA;
       
        $jugada_sorteado = DB::select("SELECT FNC_DAME_JUGADA_ESTADO('".$jugada_id."') AS JUGADA_SORTEADA");
         $jugada_sorteado= $jugada_sorteado[0]->JUGADA_SORTEADA;
         //todavia no se sorteo
         if($jugada_sorteado==1){
            return "El Sorteo de esta Jugada aun no se ha realizado..";
         }elseif($jugada_sorteado==2){
             $gano = DB::select("SELECT FNC_GANO_RIFA('".$agencia_id."','".$jugada_id."','".$rifa."') AS GANO");

            $gano=$gano[0]->GANO;
        if($gano==1){
            $premio = DB::select("SELECT FNC_RIFA_PREMIO('".$rifa."') AS RIFA_PREMIO");
            $premio= $premio[0]->RIFA_PREMIO;    

            return "La Rifa Nro ".$rifa." de la Jugada Nro ".$jugada_id. " de Fecha ".$jugada_fecha." ha ganado ".$premio." Gs de Premio";

        }else{
             return "La Rifa Nro ".$rifa." de la Jugada Nro ".$jugada_id. " de Fecha ".$jugada_fecha." no ha ganado ningun Premio, siga participando... ";
        }
         }
        
        

    }

    function VerificarRifaWeb($rifa,$token){
        $agencia_id = DB::select("SELECT FNC_DAME_AGENCIA_ID_X_RIFA('".$rifa."','".$token."') AS AGENCIA_ID");
        $agencia_id=$agencia_id[0]->AGENCIA_ID;
        $agencia_nombre = DB::select("SELECT FNC_DAME_AGENCIA_NOMBRE('".$agencia_id."') AS AGENCIA_NOMBRE");
        $agencia_nombre=$agencia_nombre[0]->AGENCIA_NOMBRE;
        $jugada_id = DB::select("SELECT FNC_DAME_JUGADA_ID_X_AGENCIA_ID('".$agencia_id."') AS 'JUGADA_ID'");
        $jugada_id=$jugada_id[0]->JUGADA_ID;
        $jugada_fecha = DB::select("SELECT DATE_FORMAT(FNC_DAME_JUGADA_FECHA('".$jugada_id."'), '%W %d %M del %Y') AS 'JUGADA_FECHA';");
        $jugada_fecha=$jugada_fecha[0]->JUGADA_FECHA;
        $gano = DB::select("SELECT FNC_GANO_RIFA('".$agencia_id."','".$jugada_id."','".$rifa."') AS GANO");
        $gano=$gano[0]->GANO;
        if($gano==1){
            $premio = DB::select("SELECT FNC_RIFA_PREMIO('".$rifa."') AS RIFA_PREMIO");
            $premio= $premio[0]->RIFA_PREMIO;    
          
            $msg = "La Rifa Nro ".$rifa." de la Jugada Nro ".$jugada_id. " de Fecha ".$jugada_fecha." ha ganado ".$premio." Gs de Premio ";
            return view('frontend.premios.ganador',['msg'=>$msg]);

        }else{
             $msg = "La Rifa Nro ".$rifa." de la Jugada Nro ".$jugada_id. " de Fecha ".$jugada_fecha." no ha ganado ningun Premio, siga participando... ";
                         return view('frontend.premios.sinpremio',['msg'=>$msg]);


       


        }
        

    }

    public function ListarSorteosAPI($agencia,$fecha){
        $data =DB::select( "CALL PRO_VER_RESUMEN_SORTEOS('".$agencia."','".$fecha."')");
        return $data;
    }
    public function ListarSorteosWeb(){
        
        $user = Auth::user();
        $_agencia_id = DB::select("SELECT FNC_DAME_AGENCIA_ID_X_USUARIO_ID('".$user->id."')  AS 'AGENCIA_ID'");
        $_agencia_id=$_agencia_id[0]->AGENCIA_ID;
        $agencia_id = isset($_GET['a']) ? $_GET['a'] : $_agencia_id;
        $f1= isset($_GET['f1']) ? $_GET['f1'] : date('y-m-d');
        $f2= isset($_GET['f2']) ? $_GET['f2'] : date('y-m-d');
        $agencia_nombre = DB::select("SELECT FNC_DAME_AGENCIA_NOMBRE('".$agencia_id."') AS 'AGENCIA_NOMBRE'");
        $agencia_nombre=$agencia_nombre[0]->AGENCIA_NOMBRE;
      


         
            $data = DB::select("CALL PRO_VER_RESUMEN_SORTEOS_X_AGENCIA_RANGO('".$agencia_id."','".$f1."','".$f2."');");
        //enviamos las variales a la vista
        return view('admin.sorteos.resumen',['agencia_id'=>$agencia_id,'agencia_nombre'=>$agencia_nombre,'data'=>$data,
'desde'=>$f1,'hasta'=>$f2]);
    }

    public function FormCargarSorteoWeb(){

        $user = Auth::user();
        $agencia_id = DB::select("SELECT FNC_DAME_AGENCIA_ID_X_USUARIO_ID('".$user->id."')  AS 'AGENCIA_ID'");
        $jugada_id = DB::select("SELECT FNC_DAME_JUGADA_ID_X_AGENCIA_ID('".$agencia_id[0]->AGENCIA_ID."') AS 'JUGADA_ID'");
        $jugada_fecha = DB::select("SELECT FNC_DAME_JUGADA_FECHA('".$jugada_id[0]->JUGADA_ID."') AS 'JUGADA_FECHA'");
        $agencia_nombre = DB::select("SELECT FNC_DAME_AGENCIA_NOMBRE('".$agencia_id[0]->AGENCIA_ID."') AS 'AGENCIA_NOMBRE'");

        //enviamos las variales a la vista
        return view('admin.sorteos.cargar',['agencia_id'=>$agencia_id[0]->AGENCIA_ID,'agencia_nombre'=>$agencia_nombre[0]->AGENCIA_NOMBRE,'jugada_id'=>$jugada_id[0]->JUGADA_ID,'jugada_fecha'=>$jugada_fecha[0]->JUGADA_FECHA]);
    }


     public function GuardarSorteoWeb(Request $req){
        $data = $req->all();
        
        //dd($data);
        $sorteo = new Sorteos();
        $sorteo->fecha=date('Y-m-d');
        $sorteo->hora=date('H:i:s');
        $sorteo->jugada_id=$data['jugada_id'];
        $sorteo->premio_id=1;
        $sorteo->rifa_nro=$data['sorteo_1'];
        $sorteo->agencia_id=$data['agencia_id'];
        $sorteo->save();

        $sorteo = new Sorteos();
        $sorteo->fecha=date('Y-m-d');
        $sorteo->hora=date('H:i:s');
        $sorteo->jugada_id=$data['jugada_id'];
        $sorteo->rifa_nro=$data['sorteo_2'];
        $sorteo->premio_id=2;
        $sorteo->agencia_id=$data['agencia_id'];
        $sorteo->save();

        $sorteo = new Sorteos();
        $sorteo->fecha=date('Y-m-d');
        $sorteo->hora=date('H:i:s');
        $sorteo->jugada_id=$data['jugada_id'];
        $sorteo->rifa_nro=$data['sorteo_3'];
        $sorteo->premio_id=3;  
        $sorteo->agencia_id=$data['agencia_id'];
        $sorteo->save();

    }
}