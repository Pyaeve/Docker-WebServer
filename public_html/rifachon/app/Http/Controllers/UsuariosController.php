<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\User;
use DB;
use Auth;
class UsuariosController extends Controller
{
    //
     //login
    public function LoginUsuario($email,$pass){

        $data = \DB::select(\DB::raw("SELECT FNC_LOGIN('".$email."','".$pass."') as usuario"));

        if ($data[0] ->usuario==-1){
            return "[]";
        }else {
            return \DB::select("CALL PRO_DAME_USUARIO_DATOS('".$data[0]->usuario."')");
        }
    }

//
    function CargarFormRegistro(){

        $user=User::findOrFail(Auth::user()->id);

        if($user->hasRole('Developer')){
           $roles=Role::all();
           $roles_data=[];
               foreach ($roles as $rol) {
                  $roles_data[$rol->name]=$rol->name;
               }

        }elseif ($user->hasRole('Admin')) {
             $roles=Role::all();
            $roles_data=[];
               foreach ($roles as $rol) {
                  $roles_data[$rol->name]=$rol->name;
               }
        }  elseif ($user->hasRole('Contador')) {
             $roles=Role::all();
            $roles_data=[];
               foreach ($roles as $rol) {
                  $roles_data[$rol->name]=$rol->name;
               }
        

       } else{
            $roles_data['1']='Developer';
        }
        $user=Auth::user()->id;
        return view('admin.usuarios.cargar',['roles'=>$roles_data]);
    }

    public function RegistrarUsuario(Request $req){
        $req->validate([
            'name' => 'required|string|max:255',
            'sername' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
    
        $data=$req->all();

        $data['activation_code']=str_random(20);
          //dd($data);
        $user=User::create([
            'name' => $data['name'],
            'sername' => $data['sername'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'password_text'=>$data['password'],
            'activation_code'=>$data['activation_code'],
            'activation_status'=>0
        ]);
        $user->assignRole($data['role']);
        
        EmpresasUsuarios::create(['empresa_id'=>$data['empresa_id'],'user_id'=>$user->id]);
        return redirect(route('admin.usuarios.resumen'));
    }


    public function MostrarPerfilWeb(){
        $data = Auth::user();
        return view('admin.usuarios.perfil',['data'=>$data]);
    }

}
