<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB, Validator;
use Illuminate\Support\Str;
use Vinkla\Hashids\Facades\Hashids;
use App\Models\Puja;
use App\Models\Modo;
use App\Models\Subasta;
use App\Models\Cierre_Subasta;
use App\Models\User;

use App\Services\Admin\{
	ImageService
};

class CierreSubastaCliente extends Controller
{
    //
    public function __construct()  
    {
        $this->middleware('auth');   
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

    public function postcierre(Request $request)
    {
          //
          $rules = [
            'modoEntrega' => 'required',
            'modoPago' => 'required',
            'comprobanteimg' => 'required'
        ];

        $messages = [
            'modoEntrega.required' => 'El Campo modo de entrega es requerido',
            'modoPago.required'=> 'El Campo modo de Pago es requerido',
            'comprobanteimg.required'=> 'El Comprobante de Pago es requerido',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):
            return response()->json(['errors'=>$validator->errors(), 'code' => '422']);
        else:
            // desencripto de la puja
            $decrypt_id = Hashids::decode($request->hddpuja_id);
            $imgComprobante = explode("|*|", $request->comprobanteimg);

            // Monto de la Puja ganadora
            $montoPuja = Puja::getMount($decrypt_id[0]);

            // comisión 5% de la Puja Ganadora
            $comision = $montoPuja[0]->puja * 5 /100;

            $data = [
                "puja_id" => $decrypt_id[0],
                "modo_id" =>$request->modoEntrega,
                "modalidad_pago"=>$request->modoPago,
                "imagen_comprobante" =>$imgComprobante[0],
                "comision" => $comision,
                "estado_pago"=>'1',
                "estado_entrega"=>'1',
            ];

            if(Cierre_Subasta::create($data)):
                // Actualiza el estado de la puja a "En proceso"
                Puja::inproccess($decrypt_id[0]);
                self::moveComprobante($imgComprobante[0]);

                return response()->json(['msg'=>'sucess', 'code' => '200', 'url'=>url('/user/pujas')]);

            else:
                return response()->json(['errors'=>$validator->errors(), 'code' => '422']);
            endif;

        endif;
    }

    public function imgTmp(Request $request)
    {
        $rules = [
            'imagen'=>'mimes:jpeg,png,jpg,gif,webp|max:2048',
        ];

        $messages = [
                
                'imagen.max'=>'El Tamaño de la Imagen no debe ser mayor a 2MB',
                'imagen.mimes'=>'La extensión de la Imagen principal debe ser JPEG, PNG, JPG, GIF, .WEBP',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):
            return response()->json(['errors'=>$validator->errors(), 'code' => '422']);
        else:
            $data = ImageService::subirImagenTmp($request);
            if($data):
                return response()->json(['data'=>$data, 'code' => '200']);
            else:
                return response()->json(['errors'=>$validator->errors(), 'code' => '423']);
            endif;

        endif;
    }

    public function moveComprobante($comprobante)
    {
        $destino =  public_path('assets/images/comprobantes/');
        echo ImageService::moveimage($comprobante ,$destino);
    }

    public function getDataUser(Request $request, $usuario_id)
    {
        if (!$request->ajax()):
            return redirect('/user/cierre-subasta');
        endif;

        $decrypt_id = Hashids::decode($usuario_id);
        $UsuarioData = User::find($decrypt_id[0]);
        return response()->json($UsuarioData);
        // $usuario_id = Cierre_Subasta::find($decrypt_id[0]);
    }
}
