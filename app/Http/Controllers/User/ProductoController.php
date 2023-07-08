<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB, Validator;
use Illuminate\Support\Str;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Facades\File;
use App\Models\Producto;
use App\Models\Categoria;
use Auth;

use App\Services\Admin\{
	ProductoService,
	ImageService
};

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()  
    {
        $this->middleware('auth');
        $this->middleware('can:admin.productos.index');
    }
    
    public function index(Request $request)
    {
        //

        $nproducto = isset($request->producto) ? $request->producto : '';
        $ncategoria = isset($request->categoria) ? $request->categoria : '';
        $estado  = isset($request->estado) ? $request->estado : '_all_';

        $user_id = Auth::user()->user_id;

        $username = Auth::user()->usuario;

        $valueRol = DB::table('roles as r')->select('r.value','mr.model_id')
        ->join('model_has_roles as mr', function($join)
        {
            $join->on('r.id', '=', 'mr.role_id');
        })
        ->where('mr.model_id',$user_id)->get();

        $categorias = Categoria::getCategoryList();
        $productos = Producto::getProductsList($nproducto, $ncategoria, $estado, $valueRol, $username);

        if ($request->ajax()):
            return view('users.data.productos-data', compact('productos', 'categorias'));
        endif;
    
        return view('users.productos', compact('productos', 'categorias'));
    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categorias = Categoria::getCategoryList();

        return view('users.crud-productos', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        if (!$request->ajax()):
            return redirect('/admin/productos');
        endif;

        
        $rules = [  
            'categoriaProducto' => 'required|exists:categorias,categoria_id',
            'nombreProducto' => 'required',
           
        ];
        
        $messages = [
            'categoriaProducto.required ' => 'El campo Categoría del Producto es requerido',
            'nombreProducto.required' => 'El campo Nombre del Producto es requerido',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):
            return response()->json(['errors'=>$validator->errors(), 'code' => '422']);
        else:
            $filename = NULL;
            $tempimg = '';
            $username = Auth::user()->usuario;
            if(isset($request->imgproducto)):
                $arrayimg = explode("|*|", $request->imgproducto);
                $filename=$arrayimg[0];
                $tempimg = $arrayimg[2];
            endif;
            $data = ProductoService::ArrayProductoAdd($request, $filename, $username);
            if($producto=Producto::create($data)):
                if($tempimg == '1'):
                    echo ProductoService::moveImage($filename);
                endif;
                return response()->json(['msg'=>'sucess', 'code' => '200', 'url'=>url('/user/productos')]);
            else:
                return response()->json(['errors'=>$validator->errors(), 'code' => '424']);
            endif;
        endif;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        return redirect('/admin/404');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $producto_id)
    {
        //
        $decrypt_id = Hashids::decode($producto_id);

        $dataP = Producto::where('producto_id', $decrypt_id)->where('oculto',0)->first();

        if($dataP == NULL):
            return redirect('/admin/productos');
        endif;

        $producto = Producto::find($decrypt_id)->first();
        $categorias = Categoria::getCategoryList();

        return view('users.crud-productos', compact('producto', 'categorias', 'producto_id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $producto_id)
    {
        //
        if (!$request->ajax()):
            return redirect('/admin/productos');
        endif;

        $rules = [
            'categoriaProducto' => 'required|exists:categorias,categoria_id',
            'nombreProducto' => 'required',
           
        ];
        
        $messages = [
            'categoriaProducto.required ' => 'El campo Categoría del Producto es requerido',
            'nombreProducto.required' => 'El campo Nombre del Producto es requerido',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):
            return response()->json(['errors'=>$validator->errors(), 'code' => '422']);
        else:
            $decrypt_id = Hashids::decode($producto_id);
            $filename = NULL;
            $tempimg = '';
            $username = Auth::user()->usuario;
            if(isset($request->imgproducto)):
                $arrayimg = explode("|*|", $request->imgproducto);
                $filename=$arrayimg[0];
                $tempimg = $arrayimg[2];
            endif;
            $data = ProductoService::ArrayProductoUpdate($request, $filename,$tempimg, $username);
            $producto = Producto::find($decrypt_id[0]);

            if($producto->update($data)):
                if($tempimg == '1'):
                    if($request->idImgProducto!=""):
                        echo ProductoService::existImagen($request->idImgProducto);
                    endif;
                    echo ProductoService::moveImage($filename);
                endif;
                return response()->json(['msg'=>'sucess', 'code' => '200', 'url'=>url('/user/productos')]);
            else:
                return response()->json(['errors'=>$validator->errors(), 'code' => '425']);
            endif;

        endif;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $producto_id, Request $request)
    {
        //
        if (!$request->ajax()):
            return redirect('/admin/productos');
        endif;

        $decrypt_id = Hashids::decode($producto_id);
        $producto = Producto::find($decrypt_id[0]);

        $data = [
            "oculto"=>1,
        ];
        if($producto->update($data)):
            return response()->json(['msg'=>'sucess', 'code' => '200']);
        endif;    
    }

    public function desactivar(Request $request, $producto_id)
    {
        if (!$request->ajax()):
            return redirect('/admin/productos');
        endif;

        $decrypt_id = Hashids::decode($producto_id);
        $producto = Producto::find($decrypt_id[0]);
        $data = [
            "estado"=>0,
        ];
        if($producto->update($data)):
            return response()->json(['msg'=>'sucess', 'code' => '200']);
        endif; 
    }

    public function activar(Request $request, $producto_id)
    {
        if (!$request->ajax()):
            return redirect('/admin/productos');
        endif;

        $decrypt_id = Hashids::decode($producto_id);
        $producto = Producto::find($decrypt_id[0]);
        $data = [
            "estado"=>1,
        ];
        if($producto->update($data)):
            return response()->json(['msg'=>'sucess', 'code' => '200']);
        endif; 
    }
    

    public function subirImagenTmp(Request $request)
    {
        if (!$request->ajax()):
            return redirect('/admin/productos');
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
            return redirect('/admin/productos');
        endif;

        $data = ImageService::eliminarImagenTmp($request);
        if($data):
             return response()->json(['code' => '200']);
        else:
             return response()->json(['errors'=>$validator->errors(), 'code' => '423']);
        endif;     
    }

    public function eliminarImagen(Request $request)
    {
        if (!$request->ajax()):
            return redirect('/admin/productos');
        endif;

        $producto = Producto::find($request->producto_id);
        $data = [
            "imagen"=>'',
        ];
        if($producto->update($data)):
            $url = public_path('assets/images/productos/'.$request->filename);
            $image = ImageService::eliminarImg($url);
            return response()->json(['code' => '200']);
        else:
            return response()->json(['code' => '205']);
        endif;
    }
}
