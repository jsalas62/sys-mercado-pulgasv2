<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB, Validator,Hash;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Facades\File;

use App\Models\User;

use Auth;


class MyPassController extends Controller
{
    //
       //
       public function __construct()  
       {
           $this->middleware('auth');
           $this->middleware('can:admin.contrasenia.index');
       
       }

    public function getchangePassword()
    {
        $currentuserid = Auth::user()->user_id;

        $usuariodata = User::find($currentuserid)->first();

        return view('users.contrasenia', compact('usuariodata'));
    }

    public function changePassword(Request $request)
    {
        if (!$request->ajax()):
            return redirect('/users/usuarios');
        endif;

        $rules = [
            'passActualUsuario'=>'required|min:6',
            'passNuevaUsuario'=>'required|min:8',
            'passRepetirUsuario'=>'required|min:8|same:passNuevaUsuario'
        ];
        
        $messages = [
            'passActualUsuario.required' => 'El Campo Contraseña Actual es requerido',
            'passActualUsuario.min' => 'La contraseña Actual debe contener al menos 8 carácteres',
            'passNuevaUsuario.required' => 'El Campo Nueva Contraseña es requerido',
            'passNuevaUsuario.min' => 'La Nueva contraseña debe contener al menos 8 carácteres',
            'passRepetirUsuario.required' => 'Es necesario confirmar la contraseña',
            'passRepetirUsuario.min' => 'La confirmación de contraseña debe contener al menos 8 carácteres',
            'passRepetirUsuario.same' => 'Las contraseñas no coinciden.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):
            return response()->json(['errors'=>$validator->errors(), 'code' => '422']);
        else:
            $user_id = Auth::user()->user_id;
            // $passwordActual = '$2y$10$aDKFrFO0yAmMkQ1LmeYZT.0P8RYXw58PiCDhSsx5WPKup61bucJYW';
            $user = User::find($user_id);
            $newpass = Hash::make(trim($request->input('passNuevaUsuario')));

            if (Hash::check($request->passActualUsuario, $user->password)) {
                // Success
                $data = [
                    "password" =>$newpass
                ];

                if( DB::table('users')->where('user_id', $user_id)->update($data)):
                    return response()->json(['msg'=>'sucess', 'code' => '200']);
                else:
                    return response()->json(['errors'=>$validator->errors(), 'code' => '425']);
    
                endif;

            }
            else 
            {
                return response()->json(['errors'=>$validator->errors(), 'code' => '423']);
            }

        endif;
    }
}
