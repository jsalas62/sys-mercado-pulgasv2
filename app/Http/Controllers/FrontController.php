<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Subasta;
use App\Models\Puja;
use Illuminate\Support\Str;
use Vinkla\Hashids\Facades\Hashids;

class FrontController extends Controller
{
    //
    public function showIndex()
    {

        $categorias = Categoria::getCategoryList();

        $productos = Producto::getProductsFront();

        $subastas = Subasta::getSubastaFront();

        return view('index', compact('categorias','productos','subastas'));
    }
    
    public function getCategoriaFront($url, Request $request)
    {
        $order = '';

        if($request->input('order')):
            $order = $request->input('order');
        endif;
    
        $categorias = Categoria::getCategoryList();

        $categoriaTitle = Categoria::getCategoriaTitleFront($url);

        $productos = Producto::getProductosFrontxUrlCategoria($url, $order);

        $url_lista = $url;

        return view('categorias', compact('categorias','productos', 'categoriaTitle', 'url_lista','order'));

    }

    public function getProductsFront(Request $request)
    {
        $productobuscar = '';
        $order = '';

        if($request->input('q')):
            $productobuscar = $request->input('q');
        else:
            if($request->input('productBusc')):
                $productobuscar = $request->input('productBusc');
            endif;
        endif;

        if($request->input('orderProduct')):
            $order = $request->input('orderProduct');
        endif; 

        $categorias = Categoria::getCategoryList();

        $productos = Producto::getProductsView($productobuscar, $order);

        return view('productos', compact('categorias', 'productobuscar', 'productos', 'order'));
    }

    // Vista Producto
    public function getProductFront($url)
    {
        $categorias = Categoria::getCategoryList();

        // $producto = Producto::getProductoxUrl($url);

        $subasta = Subasta::getSubastaxUrl($url);

        $subastas_relacionadas = Subasta::getSubastasRelacionadasxCat($url);

        return view('producto', compact('categorias', 'subasta', 'subastas_relacionadas'));
    }

    public function postFinSubasta(Request $request)
    {
        $decrypt_id = Hashids::decode($request['data_subasta']);
        $finisSubasta = Subasta::finishSubasta($decrypt_id[0]);
        $getMaxPujavaluexSubasta = Puja::getMaxPujaxSubata($decrypt_id[0]);
        return response()->json(['msg'=>'sucess', 'code' => '200']);
        // return view('front-partials.precio_oferta-front', compact('moneda', 'producto'));
    }

}
