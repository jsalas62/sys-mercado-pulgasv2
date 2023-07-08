<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Cierre_Subasta extends Model
{
    use HasFactory;

    protected $table = 'cierre__subastas';

    protected $primaryKey = 'cierre_subasta_id';

    protected $fillable = ['puja_id','modo_id','modalidad_pago','imagen_comprobante','comision','estado_pago','estado_entrega'];

    /*Estados del pago 
        1 - por verificar
        2 - Aprobado
        3 - Rechazado*/

      /*Estados de Entrega 
        1 - En espera
        2 - Enviado
        3 - Entregado
        4 - Rechazado */

    public static function getCierres($estado)
    {

        $cierres = Cierre_Subasta::select('cierre__subastas.cierre_subasta_id','p.puja','cierre__subastas.comision','p.created_at','cierre__subastas.modo_id',
                'cierre__subastas.modalidad_pago','cierre__subastas.imagen_comprobante','cierre__subastas.estado_pago','m.modalidad',
                'cierre__subastas.estado_entrega', 'pro.producto','us.user_id as ganador_id',DB::raw("CONCAT(us.nombres,' ',us.apellidos) as ganador"), 'u.user_id as subastador_id', DB::raw("CONCAT(u.nombres,' ',u.apellidos) as subastador"))
                ->join('pujas as p', function($join)
                {
                    $join->on('cierre__subastas.puja_id', '=', 'p.puja_id');
                })
                ->join('users as us', function($join)
                {
                    $join->on('p.user_id', '=', 'us.user_id');
                })
                ->join('subastas as s', function($join)
                {
                    $join->on('p.subasta_id', '=', 's.subasta_id');
                })
                ->join('productos as pro', function($join)
                {
                    $join->on('s.producto_id', '=', 'pro.producto_id');
                })
                ->join('users as u', function($join)
                {
                    $join->on('s.user_id', '=', 'u.user_id');
                })
                ->join('modos as m', function($join)
                {
                    $join->on('cierre__subastas.modo_id', '=', 'm.modo_id');
                });

        if (isset($estado) && $estado!='_all_'):

            $cierres->where('cierre__subastas.estado_pago',$estado);

        endif;

        $cierres= $cierres->orderBy('cierre__subastas.created_at', 'DESC')->paginate(10);

        return $cierres;
    }

    public static function getPujaid($cierre_id)
    {
        $valor = Cierre_Subasta::select('puja_id')->where('cierre_subasta_id',$cierre_id)->first();

        return $valor;
    }

    public static function recepcioncierrexPuja($puja_id)
    {
        Cierre_Subasta::where('puja_id',$puja_id)
        ->update([
            'estado_entrega' => 3
        ]);
    }
}
