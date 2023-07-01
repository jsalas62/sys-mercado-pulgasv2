<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB, Validator,Hash;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Facades\File;

use App\Models\User;

//exportar modelo roles de spattie
use Spatie\Permission\Models\Role; 

use Auth;

use App\Services\Admin\{
	ImageService,
    UserService
};

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()  
    {
        $this->middleware('auth');
    }


    public function index(Request $request)
    {
        //
        $nusuario = isset($request->usuario) ? $request->usuario : '';
        $estado = isset($request->estado) ? $request->estado : '_all_';

        $usuarios = User::getUsers($nusuario, $estado);

        if ($request->ajax()):
            return view('users.data.usuarios-data', compact('usuarios'));
        endif;

        return view('users.usuarios', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $roles = Role::all();
        return view('users.crud-usuarios', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        if (!$request->ajax()):
            return redirect('/users/usuarios');
        endif;

        $rules = [
            'nombreUsuario' => 'required',
            'apellidoUsuario' => 'required',
            'cborolusuario' => 'required|exists:roles,id',
            'emailUsuario' => 'required|email|unique:users,email',
            'txtUsuario' => 'required|unique:users,usuario',
            'contraseniaUsuario'=>'required|min:8',
            'confirmarContraseniaUsuario'=>'required|min:8|same:contraseniaUsuario'
        ];
        
        $messages = [
            'nombreUsuario.required' => 'El Nombre del Usuario es requerido',
            'apellidoUsuario.required' => 'El Apellido del Usuario es requerido',
            'cborolusuario.required' => 'El Rol de Usuario es requerido',
            'emailUsuario.required' => 'El Email del Usuario es requerido',
            'emailUsuario.email' => 'El Email del Usuario debe ser una dirección Válida',
            'emailUsuario.unique' => 'Ya existe el correo registrado',
            'txtUsuario.required' => 'El campo Usuario es requerido',
            'txtUsuario.unique' => 'Ya existe el Usuario',
            'contraseniaUsuario.required' => 'El Campo Contraseña es requerido',
            'contraseniaUsuario.min' => 'La contraseña debe contener al menos 8 carácteres',
            'confirmarContraseniaUsuario.required' => 'Es necesario confirmar la contraseña',
            'confirmarContraseniaUsuario.min' => 'La confirmación de contraseña debe contener al menos 8 carácteres',
            'confirmarContraseniaUsuario.same' => 'Las contraseñas no coinciden.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):
            return response()->json(['errors'=>$validator->errors(), 'code' => '422']);
        else:
            $data = UserService::addArrayUsuario($request);

            if($usuario = User::create($data)):

                $usuario->roles()->sync($request->cborolusuario);

                if(isset($data['filename']) && $data['filename'] != ''):
                    echo UserService::moveFoto($data['filename']);
                endif;

                return response()->json(['msg'=>'sucess', 'code' => '200', 'url'=>url('/users/usuarios')]);
            else:
                return response()->json(['errors'=>$validator->errors(), 'code' => '425']);
            endif;

        endif;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $user_id)
    {
        //
        $decrypt_id = Hashids::decode($user_id); 

        $dataU = User::where('user_id', $decrypt_id[0])->where('oculto',0)->first();

        if($dataU == NULL):
            return redirect('/admin/usuarios');
        endif;

        $usuario = User::find($decrypt_id)->first();

        $roles = Role::all();

        $rol_user = UserService::getRolxUser($decrypt_id);

        return view('users.crud-usuarios', compact('usuario', 'roles', 'rol_user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $user_id)
    {
        //
        if (!$request->ajax()):
            return redirect('/user/usuarios');
        endif;

        $rules = [
            'nombreUsuario' => 'required',
            'apellidoUsuario' => 'required',
            'cborolusuario' => 'required|exists:roles,id',
            'emailUsuario' => 'required|email|unique:users,email,'.$user_id.',user_id',
            'txtUsuario' => 'required|unique:users,usuario,'.$user_id.',user_id',
        ];
        
        $messages = [
            'nombreUsuario.required' => 'El Nombre del Usuario es requerido',
            'apellidoUsuario.required' => 'El Apellido del Usuario es requerido',
            'cborolusuario.required' => 'El Rol de Usuario es requerido',
            'emailUsuario.required' => 'El Email del Usuario es requerido',
            'emailUsuario.email' => 'El Email del Usuario debe ser una dirección Válida',
            'txtUsuario.required' => 'El campo Usuario es requerido',
            'txtUsuario.unique' => 'Ya existe el Usuario',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):
            return response()->json(['errors'=>$validator->errors(), 'code' => '422']);
        else:
            $passwordEditar = '';
            if($request->contraseniaUsuario != "" || $request->confirmarContraseniaUsuario != ""):
                if(strlen($request->contraseniaUsuario) >=6 || strlen($request->confirmarContraseniaUsuario) >=6):
                    if(trim($request->contraseniaUsuario) === trim($request->confirmarContraseniaUsuario)):
                        $passwordEditar = Hash::make($request->input('contraseniaUsuario'));
                    else:
                        return response()->json(['errors'=>$validator->errors(), 'code' => '424']);
                        exit;
                    endif;
                else:
                    return response()->json(['errors'=>$validator->errors(), 'code' => '423']);
                    exit;
                endif;
               
            else:
                $passwordEditar = $request->contaseniaUsuarioActual;
            endif;

            $data = UserService::updateArrayUsuario($request, $passwordEditar);

            $usuario = User::find($user_id);

            if($usuario->update($data)):

                $countData = UserService::CountRolesByUser($user_id);

                if($countData>0):
                    echo UserService::DeleteRolesByUser($user_id);
                endif;

                $usuario->roles()->sync($request->cborolusuario);

                if($data['temporalfoto'] != 0):

                    if($data['fotoactual']!=""):
                        echo UserService::exitsFotoUsuario($data['fotoactual']);
                    endif;

                    echo UserService::moveFoto($data['foto_name']);

                endif;

                return response()->json(['msg'=>'sucess', 'code' => '200', 'url'=>url('/user/usuarios')]);
            else:
                return response()->json(['errors'=>$validator->errors(), 'code' => '425']);
            endif;

            // if($producto->update($data)):
                
            // endif;

        endif;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $user_id)
    {
        //
        if (!$request->ajax()):
            return redirect('/user/usuarios');
        endif;

        $decrypt_id = Hashids::decode($user_id);
        $user = User::find($decrypt_id[0]);
        $data = [
            "oculto"=>1,
        ];
        if($user->update($data)):
            return response()->json(['msg'=>'sucess', 'code' => '200']);
        endif;    
    }

    public function desactivar(Request $request, $user_id)
    {
        if (!$request->ajax()):
            return redirect('/user/usuarios');
        endif;

        $decrypt_id = Hashids::decode($user_id);
        $user = User::find($decrypt_id[0]);
        $data = [
            "estado"=>0,
        ];
        if($user->update($data)):
            return response()->json(['msg'=>'sucess', 'code' => '200']);
        endif; 
    }
    
    public function activar(Request $request, $user_id)
    {
        if (!$request->ajax()):
            return redirect('/user/usuarios');
        endif;

        $decrypt_id = Hashids::decode($user_id);
        $user = User::find($decrypt_id[0]);
        $data = [
            "estado"=>1,
        ];
        if($user->update($data)):
            return response()->json(['msg'=>'sucess', 'code' => '200']);
        endif; 
    }

    public function subirImagenTmp(Request $request)
    {
        if (!$request->ajax()):
            return redirect('/user/usuarios');
        endif;

        $rules = [
            'imagen'=>'mimes:jpeg,png,jpg,gif,webp|max:2048',
        ];

        $messages = [
                
                'imagen.max'=>'El Tamaño de la Imagen no debe ser mayor a 2MB',
                'imagen.mimes'=>'La extensión de la Imagen principal debe ser JPEG, PNG, JPG, GIF, .WEBP',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):
            return response()->json(['errors'=>$validator->errors(), 'code' => '422']);
        else:
            $data = ImageService::subirImagenTmp($request);
            if($data):
                return response()->json(['data'=>$data, 'code' => '200']);
            else:
                return response()->json(['errors'=>$validator->errors(), 'code' => '423']);
            endif;
        endif;
    }

    public function eliminarImagenTmp(Request $request)
    {
        if (!$request->ajax()):
            return redirect('/user/usuarios');
        endif;

        $data = ImageService::eliminarImagenTmp($request);
        if($data):
             return response()->json(['code' => '200']);
        else:
             return response()->json(['errors'=>$validator->errors(), 'code' => '423']);
        endif;     
    }

    public function eliminarFoto(Request $request)
    {
        if (!$request->ajax()):
            return redirect('/user/usuarios');
        endif;
        $userfoto = UserService::eliminarFotoUsuario($request->image_id, $request->filename);
        return response()->json(['code' => '200']);
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
        ];
        
        $messages = [
            'nombredatausuario.required' => 'El Nombre del Usuario es requerido',
            'apellidodatausuario.required' => 'El Apellido del Usuario es requerido',
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
            'passNuevaUsuario'=>'required|min:6',
            'passRepetirUsuario'=>'required|min:6|same:passNuevaUsuario'
        ];
        
        $messages = [
            'passActualUsuario.required' => 'El Campo Contraseña Actual es requerido',
            'passActualUsuario.min' => 'La contraseña Actual debe contener al menos 6 carácteres',
            'passNuevaUsuario.required' => 'El Campo Nueva Contraseña es requerido',
            'passNuevaUsuario.min' => 'La Nueva contraseña debe contener al menos 6 carácteres',
            'passRepetirUsuario.required' => 'Es necesario confirmar la contraseña',
            'passRepetirUsuario.min' => 'La confirmación de contraseña debe contener al menos 6 carácteres',
            'passRepetirUsuario.same' => 'Las contraseñas no coinciden.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):
            return response()->json(['errors'=>$validator->errors(), 'code' => '422']);
        else:

            // $passwordActual = '$2y$10$aDKFrFO0yAmMkQ1LmeYZT.0P8RYXw58PiCDhSsx5WPKup61bucJYW';
            $user = User::find($request->hddusuario_idcontrasenia);
            $newpass = Hash::make(trim($request->input('passNuevaUsuario')));

            if (Hash::check($request->passActualUsuario, $user->password)) {
                // Success
                $data = [
                    "password" =>$newpass
                ];

                if( DB::table('users')->where('user_id', $request->hddusuario_idcontrasenia)->update($data)):
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
