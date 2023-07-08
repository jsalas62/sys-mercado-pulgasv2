<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Subasta extends Model
{
    use HasFactory;

    protected $table = 'subastas';

    protected $primaryKey = 'subasta_id';

    protected $fillable = ['user_id','producto_id','precio_min','precio_max','tiempo_inicio','tiempo_fin','estado','oculto'];

    /* ESTADOS DE LA SUBASTA
        1- Disponible 
        2 - Finalizada 
        3 - Cancelada 
        4 - Verificado
        5 - Entregado

    */
    public static function getSubastaList($nproducto = '', $estado = '_all_', $user)
    {
        $subastas =  Subasta::select('subastas.subasta_id','u.usuario','p.producto','p.imagen',
                                        'subastas.precio_min','subastas.precio_max','subastas.tiempo_inicio','subastas.tiempo_fin',
                                        'subastas.estado',
                                        DB::raw("(SELECT COUNT(*) from pujas where subasta_id = subastas.subasta_id) as pujas"))
                                    ->join('users as u', function($join)
                                    {
                                        $join->on('subastas.user_id', '=', 'u.user_id');
                                        $join->where('u.oculto',0);
                                    })
                                    ->join('productos as p', function($join)
                                    {
                                        $join->on('subastas.producto_id', '=', 'p.producto_id');
                                        $join->where('p.oculto',0);
                                    });
                                    if (isset($nproducto) && $nproducto != '_all_'):
                                        $subastas ->where('subastas.producto_id',$nproducto);
                                    endif;    

                                    if (isset($estado) && $estado!='_all_'):

                                        $subastas->where('subastas.estado',$estado);
                                    endif;

                                    if($user[0]->value != 'admin'):
                                        $subastas->where('subastas.user_id',$user[0]->model_id);
                                    endif;
                            
                                $subastas= $subastas->where('subastas.oculto',0)
                                ->orderBy('subastas.tiempo_inicio', 'ASC')->paginate(10);

        return $subastas;
    }

    public static function getSubastaFront()
    {
        $subastas =  Subasta::select('subastas.subasta_id','u.usuario','p.producto','p.imagen','p.url',
        'subastas.precio_min','subastas.estado')
            ->join('users as u', function($join)
            {
                $join->on('subastas.user_id', '=', 'u.user_id');
                $join->where('u.oculto',0);
            })
            ->join('productos as p', function($join)
            {
                $join->on('subastas.producto_id', '=', 'p.producto_id');
                $join->where('p.oculto',0);
            });
            $subastas= $subastas->where('subastas.estado',1)
            ->orderBy('subastas.created_at', 'DESC')->take(20)->get();

            return $subastas;
    }

    public static function getSubastaxUrl($url)
    {
        $subasta = Subasta::select('subastas.subasta_id','u.usuario','p.producto','p.imagen','p.url','p.descripcion_producto',
        'subastas.precio_min','subastas.precio_max','c.categoria as categoria','c.url as categoria_url','subastas.tiempo_inicio',
        'subastas.tiempo_fin','subastas.estado',DB::raw('(select max(puja) from pujas where subasta_id = subastas.subasta_id and estado= 1) as puja_max'))
        ->join('users as u', function($join)
        {
            $join->on('subastas.user_id', '=', 'u.user_id');
            $join->where('u.oculto',0);
        })
        ->join('productos as p', function($join)
        {
            $join->on('subastas.producto_id', '=', 'p.producto_id');
            $join->where('p.oculto',0);
        })
        ->join('categorias as c', function($join)
        {
            $join->on('p.categoria_id', '=', 'c.categoria_id');
            $join->where('c.oculto',0);
        })
        ->where('p.url',$url)
        // ->where('subastas.estado',1)
        ->first()->toArray();

        return $subasta;
    }

    public static function getSubastasFrontxUrlCategoria($url, $order)
    {

        $subastasxcat = Subasta::select('subastas.subasta_id','subastas.user_id','subastas.producto_id','subastas.precio_min',
                        'p.producto_id', 'p.producto','p.descripcion_producto','p.imagen','p.url','c.categoria as categoria')
                        ->join('productos as p', function($join)
                        {
                            $join->on('subastas.producto_id', '=', 'p.producto_id');
                            $join->where('p.oculto',0);
                        })
                        ->join('categorias as c', function($join)
                        {
                            $join->on('p.categoria_id', '=', 'c.categoria_id');
                            $join->where('c.oculto',0);
                        })
                        ->where('c.url', $url)
                        ->where('subastas.estado',1);
                        switch($order) {
                            case('alfasc'):
                                $subastasxcat->orderBy('p.producto', 'ASC');
                                break;
                            case('alfdesc'):
                                $subastasxcat->orderBy('p.producto', 'DESC');
                                break;
                            default:
                                $subastasxcat->orderBy('subastas.created_at', 'DESC');
                        }
                
                        $subastasxcat = $subastasxcat->paginate(20);
                
                        return $subastasxcat;

    }

    public static function getProductsView($productobuscar, $order)
    {
        $subastas = Subasta::select('subastas.subasta_id','subastas.user_id','subastas.producto_id','subastas.precio_min',
                                    'p.producto_id', 'p.producto','p.descripcion_producto','p.imagen','p.url')
                                    ->join('productos as p', function($join)
                                    {
                                        $join->on('subastas.producto_id', '=', 'p.producto_id');
                                        $join->where('p.oculto',0);
                                    })
                                    ->where('subastas.estado',1);
                                    if($productobuscar!=""):
                                        $subastas->where('p.producto','LIKE','%'.$productobuscar."%");
                                    endif;

                                    switch($order) {
                                        case('alfasc'):
                                            $subastas->orderBy('p.producto', 'ASC');
                                            break;
                                        case('alfdesc'):
                                            $subastas->orderBy('p.producto', 'DESC');
                                            break;
                                        default:
                                            $subastas->orderBy('subastas.created_at', 'DESC');
                                    }
                            
                                    $subastas = $subastas->paginate(20);
                            
                                    return $subastas;
    }

    public static function getPrecioMinimo($value)
    {
        $valor = Subasta::select('precio_min')->where('subasta_id',$value)->first();

        return $valor;
    }

    public static function getPrecioMax($subasta)
    {
        $maxPuja = Subasta::where('subasta_id',$subasta)->max('precio_max');
        return $maxPuja;
    }

    public static function ExistProductoInPuja($subasta, $producto_id)
    {
        $data = Subasta::where('producto_id',$producto_id)
                ->where('estado',1)->whereNotIn('subasta_id',[$subasta])->count();
        return $data;
    }

    public static function getSubastasRelacionadasxCat($url)
    {
        $categorias_producto = DB::table('productos')->select('producto_id', 'categoria_id')
            ->where('url', $url) 
            ->where('oculto',0)
            ->get()->toArray();

        $array_categorias = array();
        $array_productos = array();
        $array_categorias[] = $categorias_producto[0]->categoria_id;
        $array_productos[] = $categorias_producto[0]->producto_id;

        $subastas_relacionadas = Subasta::select('subastas.subasta_id','subastas.producto_id','subastas.precio_min',
        'p.producto','p.estado','p.url','p.imagen')
        ->join('productos as p', function($join)
        {
            $join->on('subastas.producto_id', '=', 'p.producto_id');
            $join->where('p.estado',1);
        })
        ->whereIn('p.categoria_id',$array_categorias)
        ->whereNotIn('subastas.producto_id',$array_productos)
        ->where('subastas.estado',1)
        ->where('subastas.oculto',0)
        ->orderBy('subastas.created_at', 'DESC')
        ->take(12)->get();

        // $productos_relacionados = Producto::select('producto_id', 'producto','estado','url','imagen')
      

        return $subastas_relacionadas;                                                 
    }

    public static function finishSubasta($subasta_id)
    {
        Subasta::where('subasta_id',$subasta_id)
        ->update([
            'estado' => 2
        ]);
    }

    public static function cancelSubasta($subasta_id)
    {
        Subasta::where('subasta_id',$subasta_id)
        ->update([
            'estado' => 3
        ]);
    }

    public static function verifiedSubasta($subasta_id)
    {
        Subasta::where('subasta_id',$subasta_id)
            ->update([
                'estado' => 4
            ]);
    }

    public static function ConfirmarRecepcionSubasta($subasta_id)
    {
        Subasta::where('subasta_id',$subasta_id)
        ->update([
            'estado' => 5
        ]);
    }
    
}
