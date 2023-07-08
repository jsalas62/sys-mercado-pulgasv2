<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB, Validator,Hash;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Facades\File;

use App\Models\User;

use Auth;

use App\Services\Admin\{
	ImageService,
    UserService
};

class MyDataController extends Controller
{
    //
    public function __construct()  
    {
        $this->middleware('auth');
        $this->middleware('can:admin.misdatos.index');
    
    }
    
    public function getData()
    {
        $currentuserid = Auth::user()->user_id;

        $usuariodata = User::where('user_id',$currentuserid)->first();

        return view('users.misdatos', compact('usuariodata'));
    }

    public function postData(Request $request)
    {
        if (!$request->ajax()):
            return redirect('/user/misdatos');
        endif;

        $rules = [
            'nombredatausuario' => 'required',
            'apellidodatausuario' => 'required',
            'telefonodatausuario' => 'required',
            'DireccionDataUsuario' => 'required',
        ];
        
        $messages = [
            'nombredatausuario.required' => 'El Nombre del Usuario es requerido',
            'apellidodatausuario.required' => 'El Apellido del Usuario es requerido',
            'telefonodatausuario.required' => 'El Teléfono del Usuario es requerido',
            'DireccionDataUsuario.required' => 'La Dirección del Usuario es requerido',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):
            return response()->json(['errors'=>$validator->errors(), 'code' => '422']);
        else:

            $temporalFotoUsuario = 0;
            $fotoActual = $request->fotoDataActualUsuario;
            $foto_name = '';

            $data = [
                "nombres" =>trim($request->nombredatausuario),
                "apellidos" =>trim($request->apellidodatausuario),
                "telefono"=>trim($request->telefonodatausuario),
                "direccion"=>trim($request->DireccionDataUsuario),
            ];

            if(isset($request->fotodatausuario) && $request->fotodatausuario!= ""):

                $arrayFotoDataUsuario = explode("|*|", $request->fotodatausuario);
                if($arrayFotoDataUsuario[2] == 1):
                    $url = "admin_assets/images/usuarios/".$arrayFotoDataUsuario[0];
                    $foto_name = $arrayFotoDataUsuario[0];
                    $temporalFotoUsuario = $arrayFotoDataUsuario[2];
                else:
                    $url = $request->fotoDataActualUsuario;
                endif;  

                $data["foto"] = $url;

            endif;

            $usuario = User::find($request->hdddatausuario_id);

            if($usuario->update($data)):
                if($temporalFotoUsuario != 0):

                    if($fotoActual != ""):
                        echo UserService::exitsFotoUsuario($fotoActual);
                    endif;
                    echo UserService::moveFoto($foto_name);

                endif;

                return response()->json(['msg'=>'sucess', 'code' => '200']);
            else:
                return response()->json(['errors'=>$validator->errors(), 'code' => '425']);

            endif;

        endif;
    }
}
