<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puja extends Model
{
    use HasFactory;

    protected $table = 'pujas';

    protected $primaryKey = 'puja_id';

    protected $fillable = ['user_id','subasta_id','puja','estado'];

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

    public static function getPujasList($user)
    {
        $pujas = Puja::select('pujas.puja_id','pujas.user_id','pujas.subasta_id','pujas.puja','u.usuario','pujas.estado','pujas.created_at',
                                'p.producto','p.imagen','p.url')
                                ->join('subastas as s', function($join)
                                {
                                    $join->on('pujas.subasta_id', '=', 's.subasta_id');
                                })
                                ->join('productos as p', function($join)
                                {
                                    $join->on('s.producto_id', '=', 'p.producto_id');
                                    $join->where('p.oculto',0);
                                })
                                ->join('users as u', function($join)
                                {
                                    $join->on('pujas.user_id', '=', 'u.user_id');
                                });
                if($user[0]->value != 'admin'):
                    $pujas->where('pujas.user_id',$user[0]->model_id);
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
        $maxPuja = Puja::where('subasta_id',$subasta_id)->where('estado',1)
                    ->whereRaw('puja = (select max(`puja`) from Pujas)')->get();

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

}
