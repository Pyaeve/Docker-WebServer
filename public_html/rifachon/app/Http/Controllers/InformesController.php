<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Khill\Lavacharts\Lavacharts;
use App\User;
use Auth;
use DB;

class InformesController extends Controller
{
    //

    public function VerInformeVendedoresWeb(){
        
         $user = User::findOrFail(Auth::user()->id);
        $_agencia = DB::select("SELECT FNC_DAME_AGENCIA_ID_X_USUARIO_ID('".$user->id."') AS 'AGENCIA_ID';");
        $_agencia = $_agencia[0]->AGENCIA_ID;
        $agencia = isset($_GET['a']) ? $_GET['a'] : $_agencia;
        $f1= isset($_GET['f1']) ? $_GET['f1'] : date('y-m-d');
        $f2= isset($_GET['f2']) ? $_GET['f2'] : date('y-m-d');
        $caja_resumen = DB::select("CALL PRO_VER_RESUMEN_RIFAS_AGRUPADOS_X_VENDEDOR_RANGO('".$agencia."','".$f1."','".$f2."')");
        $data = DB::select("CALL  PRO_VER_RESUMEN_RIFAS_AGRUPADOS_X_VENDEDOR_RANGO('".$agencia."','".$f1."','".$f2."');");
        $chart = new Lavacharts(); // See note below for Laravel

        $ventas1 = $chart->DataTable();

        $ventas1->addStringColumn('Vendedor')
                ->addNumberColumn('Recaudacion')
                ->addNumberColumn('Importe')
                ->addNumberColumn('Comision');
               
       // dd($use);
        foreach ($data as $node) {
            // code...
            $ventas1->addRow([$node->VENDEDOR,$node->RECAUDACION_TOTAL,$node->IMPORTE_TOTAL,$node->COMISION_TOTAL]);
        }
              
                
       
        

        $chart->BarChart('InformeVendedores', $ventas1, [
               
                'height'=>700,
                'title' => 'Ventas Diarias De Rifas',
                    'titleTextStyle' => [
                        'color'    => '#eb652c',
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

        $caja_detalles = DB::select("CALL PRO_VER_RESUMEN_RIFAS_AGRUPADOS_X_VENDEDOR_RANGO('".$agencia."','".$f1."','".$f2."');");
        return view('admin.informes.vendedores',['data'=>$caja_detalles,'chart'=>$chart,'caja'=>$caja_resumen,'agencia'=>$agencia,'desde'=>$f1,'hasta'=>$f2]);

    }
    
}
