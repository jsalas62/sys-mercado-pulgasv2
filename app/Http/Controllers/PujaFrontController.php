<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;
use DB, Validator;
use App\Models\Subasta;
use App\Models\Puja;

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
    
            if($request->puja >= $value->precio_min):
                
                $data= [
                    "subasta_id"=>$decryptsubasta[0],
                    "user_id" => $request->user,
                    "puja" => $request->puja,
                    "estado" => "1"
                ];

                $maxValue = Subasta::getPrecioMax($decryptsubasta[0]);

                $countPuja = Puja::existPuja($request->user, $decryptsubasta[0]);
                
                if($countPuja > 0):

                    $Puja = Puja::find($decryptsubasta[0]);

                    if($Puja->update($data)):
                       
                        if($request->puja > $maxValue):
                            self::updateMaxPago($decryptsubasta[0], $request->puja);
                        endif;

                        $maxValueSubasta = Subasta::getPrecioMax($decryptsubasta[0]);
                        
                        return response()->json(['msg'=>'sucess', 'code' => '200', 'maxValueSubasta' => $maxValueSubasta]);
                    endif;
                    
                else:
                    if(Puja::create($data)):

                        if($request->puja > $maxValue):
                            self::updateMaxPago($decryptsubasta[0], $request->puja);
                        endif;

                        $maxValueSubasta = Subasta::getPrecioMax($decryptsubasta[0]);

                        return response()->json(['msg'=>'sucess', 'code' => '200', 'maxValueSubasta' => $maxValueSubasta]);
                   else:
                        return response()->json(['errors'=>$validator->errors(), 'code' => '425']);
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
}
