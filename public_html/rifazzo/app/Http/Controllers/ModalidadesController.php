<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modalidades;
use App\User;
use DB;
class ModalidadesController extends Controller
{
    //listar modaliddes x Agencia
    function ListarModalidadesXAgenciaAPI($agencia){
        $data = DB::select("CALL PRO_LISTAR_MODALIDADES_X_AGENCIA('".$agencia."')");
        return $data;

    }
}
