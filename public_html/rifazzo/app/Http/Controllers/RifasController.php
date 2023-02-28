<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use DB;

use App\Asignados;
use App\Rifas;
use App\Caja;

use Khill\Lavacharts\Lavacharts;
use Auth;
class RifasController extends Controller
{
    
    function GenerarNroRifaApi($vendedor,$modalidad,$agencia){
        
        $jugada = DB::select("SELECT FNC_DAME_JUGADA_ID_X_MODALIDAD_ID('".$modalidad."','".$agencia."') AS 'JUGADA'");
        $min    = DB::select("SELECT FNC_DAME_JUGADA_NRO_DESDE('".$jugada[0]->JUGADA."') AS 'MIN'");
        $max    = DB::select("SELECT FNC_DAME_JUGADA_NRO_HASTA('".$jugada[0]->JUGADA."') AS 'MAX'");
        $nro    = DB::select("SELECT FNC_GENERAR_NUMERO('".$min[0]->MIN."','".$max[0]->MAX."') AS 'NRO'");
        $asignado = DB::select("SELECT FNC_YA_ESTA_ASIGNADO_NRO('".$jugada[0]->JUGADA."','".$nro[0]->NRO."') AS 'EXISTE'");
        if($asignado[0]->EXISTE==1){
            echo $nro[0]->NRO . " ya esta asignado";
            //$nro = DB::select("SELECT FNC_GENERAR_NUMERO('".$min[0]->MIN."','".$max[0]->MAX."') AS 'NRO'");
        }
        return $nro;    
            
       
    }

    function AsignarNroRifaApi($vendedor,$rifa,$modalidad,$agencia){
        $jugada = DB::select("SELECT FNC_DAME_JUGADA_ID_X_MODALIDAD_ID('".$modalidad."','".$agencia."') AS 'JUGADA'");
        $asignacion  =  new Asignados(); 
        $asignacion->jugada_id = $jugada[0]->JUGADA;
        $asignacion->vendedor_id = $vendedor;
        $asignacion->nro = $rifa;
        if($asignacion->save()==true){
            return true;
        }else{
             return false;
        }
       
    }
    
    function RegistrarCajaApi($jugada_id,$jugada_fecha,$agencia_id, $agencia_nombre,$vendedor_id,$vendedor_nombre,$rifa_nro,$rifa_token){

        $precio = DB::select("SELECT FNC_DAME_JUGADA_PRECIO_X_ID('".$jugada_id."') AS PRECIO");
        $precio = $precio[0]->PRECIO;
        $caja = new Caja();
        $caja->fecha = Date("Y-m-d");
        $caja->hora = Date("H:M:s");
        $caja->jugada_id=$jugada_id;
        $caja->agencia_id=$agencia_id;
        $caja->vendedor_id=$vendedor_id;
        $caja->rifa_nro=$rifa_nro;
        $caja->rifa_token=$rifa_token;
        $caja->cant=1;
        $caja->concepto="Venta de la Rifa Nro ".$rifa_nro.", de la Jugada Nro ".$jugada_id." por ".$vendedor_nombre;
        $caja->precio = $precio;
        $caja->ingreso = $precio;
        $caja->egreso = 0;
        $caja->save();

    }

    function VenderRifaApi(Request $req){
        $data = $req->all();
      
        $jugada_id = $data['JUGADA_ID'];
        $jugada_fecha = $data['JUGADA_FECHA'];
        $vendedor_id = $data['VENDEDOR_ID'];
        $agencia_id = $data['AGENCIA_ID'];
        $rifa_nro = $data['RIFA_NRO'];
        $modalidad = $data['MODALIDAD_ID'];
        $agencia_nombre = DB::select("SELECT FNC_DAME_AGENCIA_NOMBRE('".$agencia_id."')  AS 'AGENCIA_NOMBRE'");
        $zona_id = DB::select("SELECT FNC_DAME_ZONA_ID_X_AGENCIA_ID('".$agencia_id."')  AS 'ZONA_ID'");
        $zona_nombre = DB::select("SELECT FNC_DAME_ZONA_NOMBRE('".$zona_id[0]->ZONA_ID."')  AS 'ZONA_NOMBRE'");
        $ciudad_id = DB::select("SELECT FNC_DAME_CIUDAD_ID_X_AGENCIA_ID('".$agencia_id."')  AS 'CIUDAD_ID'");
        $ciudad_nombre = DB::select("SELECT FNC_DAME_CIUDAD_NOMBRE('".$ciudad_id[0]->CIUDAD_ID."')  AS 'CIUDAD_NOMBRE'");
        $vendedor_nombre = DB::select("SELECT FNC_DAME_VENDEDOR_NOMBRE('".$vendedor_id."')  AS 'VENDEDOR_NOMBRE'");
       

        $rifas = new Rifas();
        $rifas->agencia_id = (int) $agencia_id;
        $rifas->zona_id = $zona_id[0]->ZONA_ID;
        $rifas->ciudad_id = (int) $ciudad_id[0]->CIUDAD_ID;
        $rifas->jugada_id = (int) $jugada_id;
        $rifas->supervisor_id = 1;
        $rifas->vendedor_id = (int)$vendedor_id;
        $rifas->nro = (int) $rifa_nro;
        if(array_key_exists("POS_LAT",$data)==true){
            $rifas->lat = (double) $data['POS_LAT'];
        }elseif(array_key_exists("POS_LNG",$data)==true){
            $rifas->lng = (double) $data['POS_LNG'];
        }

        
     
        $rifas->token=str_random(12);

        if($rifas->save()==true){
          if($this->AsignarNroRifaApi($vendedor_id,$rifa_nro,$modalidad,$agencia_id)==true){
            $this->RegistrarCajaApi($rifas->jugada_id,$rifas->jugada_fecha,$rifas->agencia_id, $rifas->agencia_nombre,$vendedor_id,$vendedor_nombre[0]->VENDEDOR_NOMBRE,$rifa_nro,$rifas->token);
            $data = DB::select("CALL PRO_VER_RIFA_DETALLE('".$rifa_nro."','".$rifas->token."');");
         
            return $data; 
          }
        }




       
       

    
    }

    public function VerResumenVentasGraficaWeb(){
        
        $user_id=\Auth::user()->id;
        $agencia = DB::select("SELECT FNC_DAME_AGENCIA_ID_X_USUARIO_ID('".$user_id."')  AS 'AGENCIA_ID'");
        $agencia=$agencia[0]->AGENCIA_ID;

       // dd($agencia);
        $data = DB::select("CALL PRO_VER_RESUMEN_CAJA_X_AGENCIA_7DIAS('".$agencia."')");

        $chart = new Lavacharts(); // See note below for Laravel

        $ventas1 = $chart->DataTable();

        $ventas1->addDateColumn('Fecha')
                ->addNumberColumn('Recaudacion')
                ->addNumberColumn('Importe')
                ->addNumberColumn('Comision');
               
       // dd($use);
        foreach ($data as $node) {
            // code...
            $ventas1->addRow([$node->FECHA,$node->RECAUDACION_TOTAL,$node->IMPORTE_TOTAL,$node->COMISION_TOTAL]);
        }
              
        

        $chart->ColumnChart('VentasDiarias', $ventas1, [
                'isStacked'=>false,
                'height'=>400,
                'title' => 'Ventas Diarias De Rifas',
                    'titleTextStyle' => [
                        'color'    => '#eb6b2c',
                        'fontSize' => 14,
                        'alignment'=>'center',
                    ],
                'is3D'=>true,

                'animation'=>[
                'startup'=>true,
                'duration'=>1000,
                'easing'=>'inAndOut',
                ],
                
        ]);

        return view('admin.rifas.resumen',['chart'=>$chart]);
    }
    
    /*
    * MostratFormrifaWeb
    * Muestra el formulario para
    *
    */
    function MostrarFormVenderRifaWeb(){
        $user = Auth::user()->id;
        //vendedor
        $vendedor = DB::select("SELECT FNC_DAME_VENDEDOR_ID_X_USUARIO_ID('".$user."') AS 'VENDEDOR_ID'");
        // dd($vendedor);
        $vendedor=$vendedor[0]->VENDEDOR_ID;
        //vendedor nomnre
          $vendedor_nombre = DB::select("SELECT FNC_DAME_VENDEDOR_NOMBRE('".$vendedor."')  AS 'VENDEDOR_NOMBRE'");
        $vendedor_nombre=$vendedor_nombre[0]->VENDEDOR_NOMBRE;
       
        //jugada id
        $jugada_id = DB::select("SELECT FNC_DAME_JUGADA_ID_X_VENDEDOR_ID('".$vendedor."') AS 'JUGADA_ID'");
        $jugada_id =$jugada_id[0]->JUGADA_ID;
        //fecha de sorteo de la jugada
        $jugada_fecha = DB::select("SELECT FNC_DAME_JUGADA_FECHA('".$jugada_id."') AS 'JUGADA_FECHA'");
        $jugada_fecha= $jugada_fecha[0]->JUGADA_FECHA;
        //precio
        $jugada_precio = DB::select("SELECT FNC_DAME_JUGADA_PRECIO('".$jugada_id."') AS 'JUGADA_PRECIO';");
        $jugada_precio=$jugada_precio[0]->JUGADA_PRECIO;
        
        //premio1
        $jugada_premio1 = DB::select("SELECT FNC_DAME_JUGADA_PREMIO_1('".$jugada_id."') AS 'JUGADA_PREMIO';");
        $jugada_premio1=$jugada_premio1[0]->JUGADA_PREMIO;
        
        //premio2
        $jugada_premio2 = DB::select("SELECT FNC_DAME_JUGADA_PREMIO_2('".$jugada_id."') AS 'JUGADA_PREMIO';");
        $jugada_premio2=$jugada_premio2[0]->JUGADA_PREMIO;
    
        //premio3
        $jugada_premio3 = DB::select("SELECT FNC_DAME_JUGADA_PREMIO_3('".$jugada_id."') AS 'JUGADA_PREMIO';");
        $jugada_premio3=$jugada_premio3[0]->JUGADA_PREMIO;
        
        //agencia id
        $agencia_id = DB::select("SELECT FNC_DAME_AGENCIA_ID_X_VENDEDOR_ID('".$vendedor."')  AS 'AGENCIA_ID'");
        $agencia_id = $agencia_id[0]->AGENCIA_ID;

        //agencia nombre
        $agencia_nombre = DB::select("SELECT FNC_DAME_AGENCIA_NOMBRE('".$agencia_id."')  AS 'AGENCIA_NOMBRE'");
        $agencia_nombre = $agencia_nombre[0]->AGENCIA_NOMBRE;
        
        //zona id
        $zona_id = DB::select("SELECT FNC_DAME_ZONA_ID_X_AGENCIA_ID('".$agencia_id."')  AS 'ZONA_ID'");
        $zona_id=$zona_id[0]->ZONA_ID;
        
        //zona nombre
        $zona_nombre = DB::select("SELECT FNC_DAME_ZONA_NOMBRE('".$zona_id."')  AS 'ZONA_NOMBRE'");
        $zona_nombre=$zona_nombre[0]->ZONA_NOMBRE;
        
        //ciudad id
        $ciudad_id = DB::select("SELECT FNC_DAME_CIUDAD_ID_X_AGENCIA_ID('".$agencia_id."')  AS 'CIUDAD_ID'");
        $ciudad_id =$ciudad_id[0]->CIUDAD_ID;
       
        //ciudad nombre
        $ciudad_nombre = DB::select("SELECT FNC_DAME_CIUDAD_NOMBRE('".$ciudad_id."')  AS 'CIUDAD_NOMBRE'");
        $ciudad_nombre=$ciudad_nombre[0]->CIUDAD_NOMBRE;
      

        $modalidades = DB::select("CALL PRO_LISTAR_MODALIDADES('0');");
        $modalidades_array=[];
        foreach($modalidades AS $node){
            $modalidades_array[$node->ID]=$node->MODALIDAD;
        }

        return view('admin.rifas.form_venta',['vendedor_id'=>$vendedor,
            'vendedor_nombre'=>$vendedor_nombre,
            'jugada_id'=>$jugada_id,'jugada_fecha'=>$jugada_fecha, 'jugada_precio'=>$jugada_precio,
            'jugada_premio1'=>$jugada_premio1,'jugada_premio2'=>$jugada_premio2,
            'jugada_premio3'=>$jugada_premio3,
            'ciudad_id'=>$ciudad_id,'ciudad_nombre'=>$ciudad_nombre,
            'zona_id'=>$zona_id,'zona_nombre'=>$zona_nombre,
            'agencia_id'=>$agencia_id,'agencia_nombre'=>$agencia_nombre,
            'modalidades'=>$modalidades_array
        ]);
    } 

    //metodo para vender por la web
    function VenderRifaWeb(Request $req){
        $data = $req->all();
        //dd($data);
        $jugada_id = $data['jugada_id'];
        $jugada_fecha = DB::select("SELECT FNC_DAME_JUGADA_FECHA('".$jugada_id."') AS 'JUGADA_FECHA'");
        $agencia_id = DB::select("SELECT FNC_DAME_AGENCIA_ID_X_VENDEDOR_ID('".$data['vendedor_id']."')  AS 'AGENCIA_ID'");
        $agencia_nombre = DB::select("SELECT FNC_DAME_AGENCIA_NOMBRE('".$agencia_id[0]->AGENCIA_ID."')  AS 'AGENCIA_NOMBRE'");
        $zona_id = DB::select("SELECT FNC_DAME_ZONA_ID_X_AGENCIA_ID('".$agencia_id[0]->AGENCIA_ID."')  AS 'ZONA_ID'");
        $zona_nombre = DB::select("SELECT FNC_DAME_ZONA_NOMBRE('".$zona_id[0]->ZONA_ID."')  AS 'ZONA_NOMBRE'");
        $ciudad_id = DB::select("SELECT FNC_DAME_CIUDAD_ID_X_AGENCIA_ID('".$agencia_id[0]->AGENCIA_ID."')  AS 'CIUDAD_ID'");
        $ciudad_nombre = DB::select("SELECT FNC_DAME_CIUDAD_NOMBRE('".$ciudad_id[0]->CIUDAD_ID."')  AS 'CIUDAD_NOMBRE'");
        $vendedor_nombre = DB::select("SELECT FNC_DAME_VENDEDOR_NOMBRE('".$data['vendedor_id']."')  AS 'VENDEDOR_NOMBRE'");
      
        

        $rifas = new Rifas();
        $rifas->agencia_id = $agencia_id[0]->AGENCIA_ID;
        $rifas->zona_id = $zona_id[0]->ZONA_ID;
        $rifas->ciudad_id = $ciudad_id[0]->CIUDAD_ID;
        $rifas->jugada_id = $jugada_id;
        $rifas->supervisor_id = 1;
        $rifas->vendedor_id = $data['vendedor_id'];
        $rifas->nro = $data['rifa_nro'];
        $rifas->token=str_random(12);

        if($rifas->save()==true){
          if($this->AsignarNroRifaApi($data['vendedor_id'],$data['rifa_nro'],$data['modalidad_id'],$data['agencia_id'])==true){
            $this->RegistrarCajaApi($rifas->jugada_id,$rifas->jugada_fecha,$rifas->agencia_id, $rifas->agencia_nombre,$data['vendedor_id'],$vendedor_nombre[0]->VENDEDOR_NOMBRE,$data['rifa_nro'],$rifas->token);
            $data = DB::select("CALL PRO_VER_RIFA_DETALLE('".$data['rifa_nro']."','".$rifas->token."');");
         
            return view('admin.rifas.venta_exitosa',['data'=>$data]); 
          }
        }
    
    }

    

}
