<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Caja;
use App\User;
use DB;
use Auth;
use App\Rifas;


use Khill\Lavacharts\Lavacharts;

class CajaController extends Controller
{
    //
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function IndexVendedorCajaWeb(){

        $user = User::findOrFail(Auth::user()->id);
        $vendedor = DB::select("SELECT FNC_DAME_VENDEDOR_ID_X_USUARIO_ID('".$user->id."') AS 'VENDEDOR_ID';");
        $vendedor = $vendedor[0]->VENDEDOR_ID;
        //dd($vendedor);
        return view('admin.caja.vendedor',['vendedor'=>$vendedor]);
    }
     public function IndexAgenciaCajaWeb(){

        $user = User::findOrFail(Auth::user()->id);
        $agencia = DB::select("SELECT FNC_DAME_AGENCIA_ID_X_USUARIO_ID('".$user->id."') AS 'AGENCIA_ID';");
        $agencia = $agencia[0]->AGENCIA_ID;
        //dd($agencia);
        return view('admin.caja.agencia',['agencia'=>$agencia]);
    }
    //ver resumen por vendedor

    public function ResumenCajaVendedorWeb(){
        $vendedor = $_GET['v'];
        $fecha = $_GET['f'];
        $caja_resumen = DB::select("CALL PRO_VER_RESUMEN_CAJA_X_VENDEDOR('".$vendedor."','".$fecha."')");
        $data = DB::select("CALL PRO_VER_RESUMEN_CAJA_X_VENDEDOR('".$vendedor."','".$fecha."');");
        $chart = new Lavacharts(); // See note below for Laravel

        $ventas1 = $chart->DataTable();

        $ventas1->addNumberColumn('Ventas')
                ->addNumberColumn('Comision');
                
       // dd($use);
        foreach ($data as $node) {
            // code...

            $ventas1->addRow([$node->IMPORTE_TOTAL,$node->COMISION_TOTAL]);
        }
              
        

        $chart->ColumnChart('CajaVendedor', $ventas1, [
               
                'height'=>400,
                'title' => 'Ventas Diarias De Rifas',
                    'titleTextStyle' => [
                        'color'    => '#eb6b2c',
                        'fontSize' => 20,
                        'alignment'=>'center',
                    ],
                

                'animation'=>[
                'startup'=>true,
                'duration'=>1000,
                'easing'=>'inAndOut',
                ],
                'events'=>['ready'=>'LoadReady'],
                

                
        ]);

        $caja_detalles = DB::select("CALL PRO_VER_DETALLES_CAJA_X_VENDEDOR('".$vendedor."','".$fecha."');");
        return view('admin.caja.resumen_vendedor',['data'=>$caja_detalles,'chart'=>$chart,'caja'=>$caja_resumen,'vendedor'=>$vendedor,'fecha'=>$fecha]);

    }

//ver resumen por agencia
    
    public function ResumenCajaAgenciaWeb(){
         $user = User::findOrFail(Auth::user()->id);
        $_agencia = DB::select("SELECT FNC_DAME_AGENCIA_ID_X_USUARIO_ID('".$user->id."') AS 'AGENCIA_ID';");
        $_agencia = $_agencia[0]->AGENCIA_ID;
        $agencia = isset($_GET['a']) ? $_GET['a'] : $_agencia;
        $f1= isset($_GET['f1']) ? $_GET['f1'] : date('y-m-d');
        $f2= isset($_GET['f2']) ? $_GET['f2'] : date('y-m-d');
        $caja_resumen = DB::select("CALL PRO_VER_RESUMEN_CAJA_X_AGENCIA_RANGO('".$agencia."','".$f1."','".$f2."')");
        $data = DB::select("CALL PRO_VER_RESUMEN_CAJA_X_AGENCIA_RANGO('".$agencia."','".$f1."','".$f2."');");
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
              
                
       
        

        $chart->ColumnChart('CajaAgencia', $ventas1, [
               
                'height'=>400,
                'title' => 'Ventas Diarias De Rifas',
                    'titleTextStyle' => [
                        'color'    => '#eb6b2c',
                        'fontSize' => 20,
                        'alignment'=>'center',
                    ],
                

                'animation'=>[
                'startup'=>true,
                'duration'=>1000,
                'easing'=>'inAndOut',
                ],
                'events'=>['ready'=>'LoadReady'],
                

                
        ]);

        $caja_detalles = DB::select("CALL PRO_VER_DETALLES_CAJA_X_AGENCIA_RANGO('".$agencia."','".$f1."','".$f2."');");
        return view('admin.caja.resumen_agencia',['data'=>$caja_detalles,'chart'=>$chart,'caja'=>$caja_resumen,'agencia'=>$agencia,'desde'=>$f1,'hasta'=>$f2]);

    }


}
