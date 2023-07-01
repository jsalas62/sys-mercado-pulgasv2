<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';

    protected $primaryKey = 'producto_id';

    protected $fillable = ['categoria_id','producto','descripcion_producto','url','imagen','estado','oculto', 'usuario_registra'];

    public static function getSelectProducto($rol, $usuario)
    {
        $productos = Producto::where('productos.oculto',0);
        
                    if($rol[0]->value != 'admin'):
                        $productos->where('productos.usuario_registra',$usuario);
                    endif;
                    
                    $productos = $productos->orderBy('productos.producto', 'ASC')->get();

        return $productos;
    }
    
    public static function getProductsList($nproducto = '', $ncategorias = '', $estado = '_all_', $rol, $username)
    {
        $productos =  Producto::select('productos.producto_id','productos.producto','productos.descripcion_producto',
                                        'productos.imagen','productos.url','productos.estado','c.categoria')
                                    ->join('categorias as c', function($join)
                                    {
                                        $join->on('productos.categoria_id', '=', 'c.categoria_id');
                                        $join->where('c.oculto',0);
                                    });
                                    if (isset($nproducto) && $nproducto != ''):
                                        $productos ->where('productos.producto','LIKE','%'.$nproducto."%");
                                    endif;    
                            
                                    if (isset($ncategorias) && $ncategorias!=''):
                                        $productos->where('c.categoria_id', $ncategorias);
                                    endif;  

                                    if (isset($estado) && $estado!='_all_'):

                                        $productos->where('productos.estado',$estado);
                                    endif;

                                    
                                    if($rol[0]->value != 'admin'):
                                        $productos->where('productos.usuario_registra',$username);
                                    endif;

        $productos= $productos->where('productos.oculto',0)
                                ->orderBy('productos.producto', 'ASC')->paginate(10);

        return $productos;
    }

    public static function getProductsFront()
    {
        $nroitems = 20;

        $productos = Producto::select('productos.producto_id', 'productos.producto','productos.descripcion_producto',
        'productos.imagen','productos.url','c.categoria as categoria')
        ->join('categorias as c', function($join)
        {
            $join->on('productos.categoria_id', '=', 'c.categoria_id');
            $join->where('c.oculto',0);
        })
        ->where('productos.estado',1)
        ->where('productos.oculto',0)
        ->orderBy('productos.created_at', 'DESC')
        ->take($nroitems)->get();

        return $productos;
    }   

    public static function getProductosFrontxUrlCategoria($url, $order)
    {
        $productosxcat = Producto::select('productos.producto_id', 'productos.producto','productos.descripcion_producto',
        'productos.imagen','productos.url','c.categoria as categoria')
        ->join('categorias as c', function($join)
        {
            $join->on('productos.categoria_id', '=', 'c.categoria_id');
            $join->where('c.oculto',0);
        })
        ->where('c.url', $url)
        ->where('productos.estado',1)
        ->where('productos.oculto',0);
        switch($order) {
            case('alfasc'):
                $productosxcat->orderBy('productos.producto', 'ASC');
                break;
            case('alfdesc'):
                $productosxcat->orderBy('productos.producto', 'DESC');
                break;
            default:
                $productosxcat->orderBy('productos.created_at', 'DESC');
        }

        $productosxcat = $productosxcat->paginate(20);

        return $productosxcat;

    }

    public static function getProductsView($productobuscar, $order)
    {
        $productos = Producto::select('productos.producto_id', 'productos.producto','productos.descripcion_producto',
                'productos.imagen','productos.url')
            ->where('productos.estado',1)
            ->where('productos.oculto',0);
        if($productobuscar!=""):
            $productos->where('productos.producto','LIKE','%'.$productobuscar."%");
            endif;
    
        $productos = $productos->where('productos.estado',1)
                                ->where('productos.oculto',0);
                                
        switch($order) {
            case('alfasc'):
                $productos->orderBy('productos.producto', 'ASC');
                break;
            case('alfdesc'):
                $productos->orderBy('productos.producto', 'DESC');
                break;
            default:
                $productos->orderBy('productos.created_at', 'DESC');
        }

        $productos = $productos->paginate(20);

        return $productos;
    }

    public static function getProductoxUrl($url)
    {
        $arrayProducto= Producto::select('productos.producto_id','productos.producto','productos.descripcion_producto',
            'productos.imagen','productos.url','c.categoria as categoria','c.url as categoria_url')
        ->join('categorias as c', function($join)
        {
            $join->on('productos.categoria_id', '=', 'c.categoria_id');
            $join->where('c.oculto',0);
        })
        ->where('productos.url',$url)
        ->where('productos.estado',1)
        ->where('productos.oculto',0)
        ->first()->toArray();

        return $arrayProducto;
    }

    public static function getProductosRelacionadosxCat($url)
    {
        $categorias_producto = Producto::select('producto_id', 'categoria_id')
            ->where('url', $url) 
            ->where('oculto',0)
            ->get()->toArray();

        $array_categorias = array();
        $array_productos = array();
        $array_categorias[] = $categorias_producto[0]['categoria_id'];
        $array_productos[] = $categorias_producto[0]['producto_id'];


        // var_dump($categorias_producto[0]['categoria_id']);
        // $array_data = array();
        // foreach($categorias_producto as $cp):
        //         $array_data['producto_id'] = $cp->producto_id;
        //         $array_data['categoria_id'] = $cp->categoria_id;
        // endforeach;

        $productos_relacionados = Producto::select('producto_id', 'producto','estado','url','imagen')
        ->whereIn('categoria_id',$array_categorias)
        ->whereNotIn('producto_id',$array_productos)
        ->where('estado',1)
        ->where('oculto',0)
        ->orderBy('created_at', 'DESC')
        ->take(12)->get();

        return $productos_relacionados;
    }
}
