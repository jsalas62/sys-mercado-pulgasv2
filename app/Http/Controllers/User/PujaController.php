<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Vinkla\Hashids\Facades\Hashids;
use DB, Validator;
use App\Models\Producto;
use App\Models\Puja;
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
    
    }

    public function getMyPujas(Request $request)
    {
        $user = Auth::user()->user_id;
        $valueRol = DB::table('roles as r')->select('r.value','mr.model_id')
                    ->join('model_has_roles as mr', function($join)
                    {
                        $join->on('r.id', '=', 'mr.role_id');
                    })
                    ->where('mr.model_id',$user)->get();

        $pujas = Puja::getPujasList($valueRol);
        return view('users.pujas', compact('pujas'));
    }

    public function verPujasxSubata($subasta_id)
    {
        $decrypt_id = Hashids::decode($subasta_id);

        $pujas = Puja::getPujasxSubasta($decrypt_id[0]);

        return view('users.data.ver-pujas', compact('pujas'));
    }
    

}
