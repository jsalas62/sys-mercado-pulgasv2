<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Vinkla\Hashids\Facades\Hashids;
use DB, Validator;
use App\Models\Producto;
use App\Models\Subasta;
use App\Models\Puja;
use Auth;


class SubastaController extends Controller
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
        $productoSubastaBuscar = $request->get('producto');
        $estadoSubastaBuscar = $request->get('estado');

        $user = Auth::user()->user_id;

        $username = Auth::user()->usuario;

        $valueRol = DB::table('roles as r')->select('r.value','mr.model_id')
                    ->join('model_has_roles as mr', function($join)
                    {
                        $join->on('r.id', '=', 'mr.role_id');
                    })
                    ->where('mr.model_id',$user)->get();

        $subastas = Subasta::getSubastaList($productoSubastaBuscar, $estadoSubastaBuscar, $valueRol);

        $productos = Producto::getSelectProducto($valueRol, $username);

        if ($request->ajax()):
            return view('users.data.subastas-data', compact('subastas'));
        endif;

         return view('users.subastas', compact('productos', 'subastas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        if (!$request->ajax()):
            return redirect('/user/account');
        endif;

        $rules = [  
            'producto_id' => 'required',
            'precio_minimo' => 'required',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required'
           
        ];
        
        $messages = [
            'producto_id.required ' => 'El Producto es requerido',
            'precio_minimo.required' => 'El campo Precio de la subasta es requerido',
            'fecha_inicio.required' => 'La fecha de Inicio es requerida',
            'fecha_fin.required' => 'La fecha de Inicio es requerida',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):
            return response()->json(['errors'=>$validator->errors(), 'code' => '422']);
        else:
            if($request->precio_minimo > 0):

                if($request->fecha_inicio < $request->fecha_fin):
                    $usuarioActual = Auth::user()->user_id;
                    $data = [
                        "user_id" =>$usuarioActual,
                        "producto_id" =>$request->producto_id,
                        "precio_min" =>$request->precio_minimo,
                        "precio_max" => 0,
                        "tiempo_inicio" => $request->fecha_inicio,
                        "tiempo_fin" => $request->fecha_fin,
                        "estado" => 1,
                        "oculto" => 0
                    ];
                    
                    if(Subasta::create($data)):
                        return response()->json(['msg'=>'sucess', 'code' => '200']);
                   else:
                        return response()->json(['errors'=>$validator->errors(), 'code' => '425']);
                   endif;

                else: 
                    return response()->json(['errors'=>$validator->errors(), 'code' => '424']);
                endif;

            else:
                return response()->json(['errors'=>$validator->errors(), 'code' => '43']);
            endif;
        endif;

    }

    /**
     * Display the specified resource.
     */
    public function show(string $subata_id)
    {
        //
        $decrypt_id = Hashids::decode($subata_id);
        if(count($decrypt_id) == 0):
            return redirect('/subastas/subastas');
        endif;
        $subasta = Subasta::find($decrypt_id[0]);
        return response()->json($subasta);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $subasta_id)
    {
        //
         //
         if (!$request->ajax()):
            return redirect('/user/account');
        endif;

        $rules = [  
            'producto_id' => 'required',
            'precio_minimo' => 'required',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required'
           
        ];
        
        $messages = [
            'producto_id.required ' => 'El Producto es requerido',
            'precio_minimo.required' => 'El campo Precio de la subasta es requerido',
            'fecha_inicio.required' => 'La fecha de Inicio es requerida',
            'fecha_fin.required' => 'La fecha de Inicio es requerida',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):
            return response()->json(['errors'=>$validator->errors(), 'code' => '422']);
        else:
            if($request->precio_minimo > 0):

                if($request->fecha_inicio < $request->fecha_fin):
                    $decrypt_id = Hashids::decode($subasta_id);
                    $usuarioActual = Auth::user()->user_id;
                    $existSubasta = Subasta::ExistProductoInPuja($decrypt_id[0],$usuarioActual, $request->producto_id);
                    if($existSubasta >  0):
                        return response()->json(['errors'=>$validator->errors(), 'code' => '426']);
                    else:
                        $subasta = Subasta::find($decrypt_id[0]);

                        $data = [
                            "user_id" =>$usuarioActual,
                            "producto_id" =>$request->producto_id,
                            "precio_min" =>$request->precio_minimo,
                            "precio_max" => 0,
                            "tiempo_inicio" => $request->fecha_inicio,
                            "tiempo_fin" => $request->fecha_fin,
                            "estado" => 1,
                            "oculto" => 0
                        ];
                    
                        if($subasta->update($data)):
                            return response()->json(['msg'=>'sucess', 'code' => '200']);
                        else:
                            return response()->json(['errors'=>$validator->errors(), 'code' => '425']);
                        endif;
                    endif;

                else: 
                    return response()->json(['errors'=>$validator->errors(), 'code' => '424']);
                endif;

            else:
                return response()->json(['errors'=>$validator->errors(), 'code' => '243']);
            endif;
        endif;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $subasta_id)
    {
        //
        if (!$request->ajax()):
            return redirect('/user/account');
        endif;
        $decrypt_id = Hashids::decode($subasta_id);
        $SiTienePujas = Puja::getHavePujas($decrypt_id[0]);
        if($SiTienePujas>0):
            return response()->json(['msg'=>'error', 'code' => '202']);
        else:
            $subasta = Subasta::find($decrypt_id[0]);
 
            if($subasta->delete()):
                return response()->json(['msg'=>'sucess', 'code' => '200']);
            else:
                return response()->json(['msg'=>'error', 'code' => '204']);
            endif;

        endif;
    }

    public function finalizar(Request $request, string $subasta_id)
    {
        if (!$request->ajax()):
            return redirect('/user/account');
        endif;
        $decrypt_id = Hashids::decode($subasta_id);
        $subasta = Subasta::find($decrypt_id[0]);
        $data = [
            "estado"=>2,
        ];
        if($subasta->update($data)):
            return response()->json(['msg'=>'sucess', 'code' => '200']);
        endif;    
    }
}
