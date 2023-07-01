<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB, Validator,Hash;
use Vinkla\Hashids\Facades\Hashids;
//exportar modelo roles de spattie
use Spatie\Permission\Models\Role; 

use App\Models\User;

use Auth;

class ClientController extends Controller
{
    //

    public function register_user(Request $request)
    {
        $rules = [
            'nameUsuario' => 'required',
            'apellidosUsuario' => 'required',
            'emailUsuario' => 'required|email|unique:users,email',
            'telUsuario' => 'required',
            'usuarioCreate' => 'required|unique:users,usuario',
            'passwordCreateUsuario'=>'required|min:6',
            'passwordSameCreateUsuario'=>'required|min:6|same:passwordCreateUsuario'
        ];
        
        $messages = [
            'nameUsuario.required' => 'El Nombre del Usuario es requerido',
            'apellidosUsuario.required' => 'El Apellido del Usuario es requerido',
            'emailUsuario.required' => 'El Email del Usuario es requerido',
            'emailUsuario.email' => 'El Email del Usuario debe ser una dirección Válida',
            'emailUsuario.unique' => 'Ya existe el correo registrado',
            'telUsuario.required' => 'El campo Teléfono es requerido',
            'usuarioCreate.required' => 'El campo Usuario es requerido',
            'usuarioCreate.unique' => 'Ya existe el Usuario',
            'passwordCreateUsuario.required' => 'El Campo Contraseña es requerido',
            'passwordCreateUsuario.min' => 'La contraseña debe contener al menos 6 carácteres',
            'passwordSameCreateUsuario.required' => 'Es necesario confirmar la contraseña',
            'passwordSameCreateUsuario.min' => 'La confirmación de contraseña debe contener al menos 6 carácteres',
            'passwordSameCreateUsuario.same' => 'Las contraseñas no coinciden.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):
            return back()->withErrors($validator)->with('msg','Se ha producido un error.')->with('typealert','danger');
        else:

            $data = [
                "nombres" => $request->nameUsuario,
                "apellidos" => $request->apellidosUsuario,
                "usuario" => $request->usuarioCreate,
                "email" => $request->emailUsuario,
                "password"=>Hash::make(trim($request->input('passwordCreateUsuario'))),
                "telefono" => $request->telUsuario
            ];

            if($usuario = User::create($data)):

                $usuario->roles()->sync('4');
                Auth::login($usuario);
                return redirect()->route('index');
            else:
                return back()->with('msg','Hubo en Error al procesar el registro.')->with('typealert','danger');
            endif;
        endif;

    }
}
