<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Vinkla\Hashids\Facades\Hashids;
use DB, Validator;
use App\Models\Producto;
use App\Models\Puja;
use App\Models\Cierre_Subasta;
use App\Models\Subasta;

use Auth;

class PujaController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     */
    public function __construct()  
    {
        $this->middleware('auth');
        $this->middleware('can:admin.pujas.index');
    }

    public function getMyPujas(Request $request)
    {
        $user = Auth::user()->user_id;
        $estadoPujabuscar = $request->get('estado');

        $valueRol = DB::table('roles as r')->select('r.value','mr.model_id')
                    ->join('model_has_roles as mr', function($join)
                    {
                        $join->on('r.id', '=', 'mr.role_id');
                    })
                    ->where('mr.model_id',$user)->get();

        $pujas = Puja::getPujasList($valueRol, $estadoPujabuscar);

        if ($request->ajax()):
            return view('users.data.pujas-data', compact('pujas'));
        endif;

        return view('users.pujas', compact('pujas'));
    }

    public function verPujasxSubata($subasta_id)
    {
        $decrypt_id = Hashids::decode($subasta_id);

        $pujas = Puja::getPujasxSubasta($decrypt_id[0]);

        return view('users.data.ver-pujas', compact('pujas'));
    }

    public function confirmarPujaRecepcion(Request $request, $puja_id)
    {
        if (!$request->ajax()):
            return redirect('/user/cierre-subasta');
        endif;

        $decrypt_id = Hashids::decode($puja_id);
        $Puja = Puja::find($decrypt_id[0]);
        $data = [
            "estado"=>7,
        ];
        $subasta_id = Puja::getSubastaid($decrypt_id[0]);
        if($Puja->update($data)):
            Subasta::ConfirmarRecepcionSubasta($subasta_id->subasta_id);
            Cierre_Subasta::recepcioncierrexPuja($decrypt_id[0]);
            return response()->json(['msg'=>'sucess', 'code' => '200']);
        endif; 
        
    }
    

}
