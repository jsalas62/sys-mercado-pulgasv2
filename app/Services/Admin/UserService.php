<?php
namespace App\Services\Admin;
 
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\Admin\ImageService;
use DB, Validator,Hash;

class UserService
{

    public static function addArrayUsuario($request)
    {
        $estado = $request->chkEstadoUsuario == "on" ? "1":"0";
        $oculto =0;

        $arrayUsuario = array();
        
        $data = [
            "nombres" =>trim($request->nombreUsuario),
            "apellidos" =>trim($request->apellidoUsuario),
            "usuario"=>trim($request->txtUsuario),
            "email"=>trim($request->emailUsuario),
            "password" => Hash::make(trim($request->input('contraseniaUsuario'))),
            "direccion"=>trim($request->direccionUsuario),
            "telefono"=>trim($request->telefonoUsuario),
        ];

        if(isset($request->fotousuario) && $request->fotousuario!= ""):
            $arrayFotoUsuario = explode("|*|", $request->fotousuario);
            $url = "admin_assets/images/usuarios/".$arrayFotoUsuario[0];

            $data["foto"] = $url;
            $data["filename"] = $arrayFotoUsuario[0];
        endif;

        $data["estado"] = $estado;
        $data["oculto"] = $oculto;
        $data['remember_token'] = Str::random(10);
        return $data;

    }

    public static function updateArrayUsuario($request, $password)
    {
        $estado = $request->chkEstadoUsuario == "on" ? "1":"0";
        $oculto =0;
        $temporalFotoUsuario = 0;
        $foto_name = '';

        $arrayUsuario = array();         
        $data = [
            "nombres" =>trim($request->nombreUsuario),
            "apellidos" =>trim($request->apellidoUsuario),
            "usuario"=>trim($request->txtUsuario),
            "email"=>trim($request->emailUsuario),
            "password" => $password,
            "direccion"=>trim($request->direccionUsuario),
            "telefono"=>trim($request->telefonoUsuario),
        ];

        if(isset($request->fotousuario) && $request->fotousuario!= ""):
            $arrayFotoUsuario = explode("|*|", $request->fotousuario);
            if($arrayFotoUsuario[2] == 1):
                $url = "admin_assets/images/usuarios/".$arrayFotoUsuario[0];
                $foto_name = $arrayFotoUsuario[0];
                $temporalFotoUsuario = $arrayFotoUsuario[2];
            else:
                $url = $request->fotoActualUsuario;
            endif;
           

            $data["foto"] = $url;

        endif;
        $data["foto_name"] = $foto_name;
        $data['fotoactual'] = $request->fotoActualUsuario;
        $data["temporalfoto"] = $temporalFotoUsuario;
        $data["estado"] = $estado;
        $data["oculto"] = $oculto;

        return $data;
    
    }
    
    public static function moveFoto($filename)
    {
        $destino =  public_path('admin_assets/images/usuarios/');
        echo ImageService::moveimage($filename ,$destino);
    }

    public static function exitsFotoUsuario($filename)
    {
        $url = public_path($filename);
        echo ImageService::eliminarImg($url);
    }

    public static function eliminarFotoUsuario($user_id, $filename)
    {
        // $url = public_path('admin_assets/images/usuarios/'.$filename);
        $url = $filename;
        $image = ImageService::eliminarImg($url);
        User::where("user_id", $user_id)->update(["foto" => ""]);
    }
    
    public static function getRolxUser($user_id)
    {
        $data = DB::table('model_has_roles')->where('model_id', $user_id)->pluck('role_id')->toArray();

        return $data;
    }

    public static function CountRolesByUser($id)
    {
        $count = DB::table('model_has_roles')->where('model_id', $id)->count();

        return $count;
    }

    public static function DeleteRolesByUser($id)
    {
        $deleted = DB::table('model_has_roles')->where('model_id', $id)->delete();
    }

}