<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Puja extends Model
{
    use HasFactory;

    protected $table = 'pujas';

    protected $primaryKey = 'puja_id';

    protected $fillable = ['user_id','subasta_id','puja','estado'];

    // Estados de la Puja 
    // 1 - pendiente
    // 2 - pérdida
    // 3 - ganada 
    // 4 - en proceso
    // 5 - verificado
    // 6 - rechazada 
    // 7 - recepcionada

    public static function getPrecioMax($subasta)
    {
        $maxPuja = Puja::where('subasta_id',$subasta)->max('puja');
        return $maxPuja;
    }

    public static function existPuja($user, $subasta)
    {
        $valor = Puja::where('user_id',$user)->where('subasta_id',$subasta)->count();

        return $valor;
    }

    public static function getHavePujas($subasta_id)
    {
        $valor = Puja::where('subasta_id',$subasta_id)->count();

        return $valor;
    }

    public static function getPujasList($user, $estado)
    {
        $pujas = Puja::select('pujas.puja_id','pujas.user_id','pujas.subasta_id','pujas.puja','u.usuario','pujas.estado','pujas.created_at',
                                'p.producto','p.imagen','p.url','cp.imagen_comprobante as comprobante','s.user_id as subastador_id')
                                ->leftJoin('cierre__subastas as cp', 'pujas.puja_id', '=', 'cp.puja_id')
                                ->join('users as u', function($join)
                                {
                                    $join->on('pujas.user_id', '=', 'u.user_id');
                                })
                                ->join('subastas as s', function($join)
                                {
                                    $join->on('pujas.subasta_id', '=', 's.subasta_id');
                                })
                                ->join('productos as p', function($join)
                                {
                                    $join->on('s.producto_id', '=', 'p.producto_id');
                                    $join->where('p.oculto',0);
                                });
                if($user[0]->value != 'admin'):
                    $pujas->where('pujas.user_id',$user[0]->model_id);
                endif;

                
                if (isset($estado) && $estado!='_all_'):

                    $pujas->where('pujas.estado',$estado);
                endif;

            $pujas= $pujas->orderBy('pujas.created_at', 'ASC')->paginate(10);

        return $pujas;
    }

    public static function getPujasxSubasta($subasta_id)
    {
        $pujas = Puja::select('pujas.puja_id','pujas.user_id','pujas.subasta_id','pujas.puja','u.usuario','pujas.estado','pujas.created_at')
                ->join('subastas as s', function($join)
                {
                    $join->on('pujas.subasta_id', '=', 's.subasta_id');
                })
                ->join('users as u', function($join)
                {
                    $join->on('pujas.user_id', '=', 'u.user_id');
                });

        $pujas= $pujas->where('pujas.subasta_id',$subasta_id)->orderBy('pujas.puja', 'DESC')->paginate(10);

        return $pujas;
    }

    public static function getMaxPujaxSubata($subasta_id)
    {
        // $maxPuja = Puja::where('subasta_id',$subasta_id)->where('estado',1)->max('puja');
        // $maxPuja = Puja::where('subasta_id',$subasta_id)->where('estado',1)
        //             ->whereRaw('puja = (select max(`puja`) from Pujas)')->get();
        $maxPuja = DB::select("select puja_id, subasta_id, puja from pujas 
                            where puja IN (SELECT MAX(puja) from pujas GROUP BY subasta_id)
                            and subasta_id = ".$subasta_id." and estado= 1 ");

        Puja::where('subasta_id',$subasta_id)->where('estado',1)
        ->update([
            'estado' => 2
        ]);

            Puja::where('puja_id',$maxPuja[0]->puja_id)
            ->update([
                'estado' => 3
            ]);

        Subasta::where('subasta_id',$subasta_id)
        ->update([
            'precio_max' => $maxPuja[0]->puja
        ]);
    
    }

    public static function isPujaGanadora($puja_id)
    {
        $value = Puja::select('estado')->where('puja_id',$puja_id)->get();

        return $value;
    }
    
    public static function getMount($puja_id)
    {
        $value = Puja::select('puja')->where('puja_id',$puja_id)->get();

        return $value;
    }

    public static function inproccess($puja_id)
    {
        Puja::where('puja_id',$puja_id)
        ->update([
            'estado' => 4
        ]);
    }

    public static function verificarPuja($puja_id)
    {
        Puja::where('puja_id',$puja_id)
        ->update([
            'estado' => 5
        ]);
    }

    public static function rechazarPuja($puja_id)
    {
        Puja::where('puja_id',$puja_id)
        ->update([
            'estado' => 6
        ]);
    }

    
    public static function recepcionPuja($puja_id)
    {
        Puja::where('puja_id',$puja_id)
        ->update([
            'estado' => 7
        ]);
    }

    public static function getSubastaid($puja_id)
    {
        $valor = Puja::select('subasta_id')->where('puja_id',$puja_id)->first();

        return $valor;
    }

    
}
