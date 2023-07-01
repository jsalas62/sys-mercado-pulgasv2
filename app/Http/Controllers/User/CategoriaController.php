<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB, Validator;
use App\Models\Categoria;
use Illuminate\Support\Str;
use Vinkla\Hashids\Facades\Hashids;

class CategoriaController extends Controller
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
        $categoriabuscar = $request->get('categoria');
        $estadocategoria = $request->get('estado');

        $categorias = Categoria::where('oculto',0);

        if (isset($categoriabuscar) && $categoriabuscar != ''):
            $categorias ->where('categoria','LIKE','%'.$categoriabuscar."%");
        endif;     

        if (isset($estadocategoria) && $estadocategoria!='_all_'):
            $categorias->where('estado',$estadocategoria );
        endif;

        $categorias = $categorias->orderBy('categoria','ASC')->paginate(10);

        if ($request->ajax()):
            return view('users.data.categorias-data', compact('categorias'));
        endif;

        return view('users.categorias', compact('categorias'));
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
            return redirect('/admin/categorias');
        endif;

        $rules = [
            'categoria'=>'required|max:60'
        ];

        $messages = [
            'categoria.required' => 'El campo Categoria es requerido',
            'categoria.max' => 'El campo Categoria debe contener como máximo 60 carácteres',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):
            return response()->json(['errors'=>$validator->errors(), 'code' => '422']);
        else:
            $urlCategoria = Str::slug($request->categoria);
            $activo = $request->activo == "true" ? "1":"0";
            $oculto =0;
            $existCategoria = Categoria::getCategoryExits('url', $urlCategoria);

            if($existCategoria>0):
                return response()->json(['errors'=>$validator->errors(), 'code' => '426']);
            else:
                $data = [
                    "categoria"=>trim($request->categoria),
                    "descripcion"=>$request->descripcion,
                    "url"=>$urlCategoria,
                    "estado"=>$activo,
                    "oculto"=>$oculto,
                ];

                if(Categoria::create($data)):
                    
                    return response()->json(['msg'=>'sucess', 'code' => '200']);
               else:
                    return response()->json(['errors'=>$validator->errors(), 'code' => '425']);
               endif;

            endif;

        endif;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $categoria_id)
    {
        //
        $decrypt_id = Hashids::decode($categoria_id);
        if(count($decrypt_id) == 0):
            return redirect('/admin/categorias');
        endif;
        $categoria = Categoria::find($decrypt_id[0]);
        return response()->json($categoria);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        return redirect('/admin/404');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $categoria_id)
    {
        //
        if(!$request->ajax()):
            return redirect('/admin/categorias');
        endif;

        $decrypt_id = Hashids::decode($categoria_id);

        $rules = [
            'categoria'=>'required|max:40'
        ];

        $messages = [
            'categoria.required' => 'El campo Categoria es requerido',
            'categoria.max' => 'El campo Categoria debe contener como máximo 60 carácteres',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        
        if($validator->fails()):

            return response()->json(['errors'=>$validator->errors(), 'code' => '422']);
        
        else:
            $urlCategoria = Str::slug($request->categoria);
            $activo = $request->activo == "true" ? "1":"0";
            $oculto =0;
            
            if($request->slug_actual!=$urlCategoria):
                $existc = Categoria::getCategoryExits($urlCategoria);
                if($existc>0):
                        
                    return response()->json(['errors'=>$validator->errors(), 'code' => '427']);
                else:
                    $categoria = Categoria::find($decrypt_id[0]);

                    $data = [
                        "categoria"=>trim($request->categoria),
                        "descripcion"=>$request->descripcion,
                        "url"=>$urlCategoria,
                        "estado"=>$activo,
                        "oculto"=>$oculto,
                    ];

                    if($categoria->update($data)):
                        return response()->json(['msg'=>'sucess', 'code' => '200']);
                    else:
                        return response()->json(['errors'=>$validator->errors(), 'code' => '425']);
                    endif;

                endif;
            else:
                $categoria = Categoria::find($decrypt_id[0]);
                $data = [
                    "categoria"=>trim($request->categoria),
                    "descripcion"=>$request->descripcion,
                    "url"=>$urlCategoria,
                    "estado"=>$activo,
                    "oculto"=>$oculto,
                ];

                if($categoria->update($data)):
                    return response()->json(['msg'=>'sucess', 'code' => '200']);
                else:
                    return response()->json(['errors'=>$validator->errors(), 'code' => '425']);
                endif;
            endif;

        endif;

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $categoria_id)
    {
        //
         //
         if (!$request->ajax()):
            return redirect('/admin/categorias');
        endif;
        $decrypt_id = Hashids::decode($categoria_id);
        $categoria = Categoria::find($decrypt_id[0]);
        $data = [
            "oculto"=>1,
        ];
        if($categoria->update($data)):
            return response()->json(['msg'=>'sucess', 'code' => '200']);
        endif;    
    }

    public function activar(Request $request, string $categoria_id)
    {
        if (!$request->ajax()):
            return redirect('/admin/categorias');
        endif;

        $decrypt_id = Hashids::decode($categoria_id);
        $categoria = Categoria::find($decrypt_id[0]);
        $data = [
            "estado"=>1,
        ];
        if($categoria->update($data)):
            return response()->json(['msg'=>'sucess', 'code' => '200']);
        endif;    
    }

    public function desactivar(Request $request, string $categoria_id)
    {
        if (!$request->ajax()):
            return redirect('/admin/categorias');
        endif;

        $decrypt_id = Hashids::decode($categoria_id);
        $categoria = Categoria::find($decrypt_id[0]);
        $data = [
            "estado"=>0,
        ];
        if($categoria->update($data)):
            return response()->json(['msg'=>'sucess', 'code' => '200']);
        endif;    
    }
}
