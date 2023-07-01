<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB, Validator;
use App\Models\Puja;
use App\Models\Modo;

use Illuminate\Support\Str;
use Vinkla\Hashids\Facades\Hashids;

class CierreSubastaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()  
    {
        $this->middleware('auth');
    
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function createCierre($puja_id, Request $request)
    {
        // desencripto de la puja
        $decrypt_id = Hashids::decode($puja_id);

        if(count($decrypt_id)==0):
            return redirect('/user/pujas');
        endif;

        // Busca si es la puja ganadora por el ID desencriptado
        $isPujaGanadora = Puja::isPujaGanadora($decrypt_id[0]);
        
        if(count($isPujaGanadora)==0):
            return redirect('/user/pujas');
        endif;

        $listadoModos = Modo::getListModos();
        $pujaid = $puja_id;

        if($isPujaGanadora[0]->estado == '3'):
            return view('users.crear-cierre', compact('listadoModos','pujaid'));
        else:
            return redirect('/user/pujas');
        endif;
     
    }
}
