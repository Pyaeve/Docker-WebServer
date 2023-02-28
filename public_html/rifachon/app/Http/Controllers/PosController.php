<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\User;
use App\Pos;

class PosController extends Controller
{
    //
    function FormCargarWeb(){
        return view('admin.pos.cargar');
    }

    function GuardarWeb(Request $req){
        $data = $req->all();
        $pos = new Pos();
        $pos->imei=$data['imei'];
        $pos->serial=$data['serial'];
        $pos->sim= $data['sim'];
        $pos->save();
        return redirect(route('backend.pos.resumen'));


    }

    function VerResumenWeb(){
        $data = DB::select("CALL PRO_LISTAR_POS('1')");

        return view('admin.pos.resumen',['data'=>$data]);
    }


}
