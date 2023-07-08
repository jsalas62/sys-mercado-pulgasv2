<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;
use DB, Validator;
use App\Models\Subasta;
use App\Models\Puja;
use Auth;

class PujaFrontController extends Controller
{
    //
    public function __construct()  
    {
        $this->middleware('auth');
    }

    public function storePuja(Request $request)
    {
        $rules = [  
            'puja' => 'required|numeric',    
        ];
        
        $messages = [
            'puja.required ' => 'la Puja es requerida',
            'puja.numeric' => 'La puja debe ser númerica',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):
            return response()->json(['errors'=>$validator->errors(), 'code' => '422']);
        else:
            $decryptsubasta = Hashids::decode($request->subasta);

            $value = Subasta::getPrecioMinimo($decryptsubasta[0]);
            
            $usuario =  Auth::user()->user_id;

            if($request->puja >= $value->precio_min):
                
                $data= [
                    "subasta_id"=>$decryptsubasta[0],
                    // "user_id" => $request->user,
                    "user_id" => $usuario,
                    "puja" => $request->puja,
                    "estado" => "1"
                ];

                $maxValue = Puja::getPrecioMax($decryptsubasta[0]);

                if($request->puja <= $maxValue):
                    return response()->json(['errors'=>$validator->errors(), 'code' => '426']);
                else:
                    $countPuja = Puja::existPuja($usuario, $decryptsubasta[0]);
                
                    // valida si el usuario logeado ya tiene pujas existentes
                    if($countPuja > 0):
    
                        $getPuja_id = Puja::select('puja_id')->where('user_id',$usuario)->where('subasta_id',$decryptsubasta[0])->first();
    
                        $Puja = Puja::find($getPuja_id->puja_id);
    
                        if($Puja->update($data)):
                           
                            // if($request->puja > $maxValue):
                            //     self::updatePuja($getPuja_id->puja_id, $request->puja);
                            // endif;
    
                            $maxValueSubasta = Puja::getPrecioMax($decryptsubasta[0]);
                            
                            return response()->json(['msg'=>'sucess', 'code' => '200', 'maxValueSubasta' => $maxValueSubasta]);
                        endif;
                        
                    else:
                        if(Puja::create($data)):
    
                            // if($request->puja > $maxValue):
                            //     self::updateMaxPago($decryptsubasta[0], $request->puja);
                            // endif;
    
                            $maxValueSubasta = Puja::getPrecioMax($decryptsubasta[0]);
    
                            return response()->json(['msg'=>'sucess', 'code' => '200', 'maxValueSubasta' => $maxValueSubasta]);
                       else:
                            return response()->json(['errors'=>$validator->errors(), 'code' => '425']);
                       endif;
                    endif;
                endif;

            else:
                return response()->json(['errors'=>$validator->errors(), 'code' => '202']);
            endif;
        endif;

    }

    public function updateMaxPago($subas_id, $value) 
    {
        Subasta::where('subasta_id',$subas_id)
        ->update([
            'precio_max' => $value
        ]);
    }

    public function updatePuja($puja_id, $value) 
    {
        Puja::where('puja_id',$puja_id)
        ->update([
            'puja' => $value
        ]);
    }
}
