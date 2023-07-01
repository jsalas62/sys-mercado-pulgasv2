<?php
namespace App\Services\Admin;
 
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\Admin\ImageService;


class ProductoService
{
    public static function ArrayProductoAdd($request, $filename, $username)
    {
        $urlproducto = Str::slug($request->nombreProducto);
        $estado = $request->chkEstadoProducto == "on" ? "1":"0";
        $oculto =0;
        $urlimagen = "assets/images/productos/".$filename;

        $data = [
            "categoria_id" => $request->categoriaProducto,
            "producto" =>$request->nombreProducto,
            "descripcion_producto" =>html_entity_decode($request->descripcion_producto),
            "imagen" => $urlimagen,
            "url" => $urlproducto,
            "estado" => $estado,
            "oculto" => $oculto,
            "usuario_registra" => $username
        ];
        
        return $data;
    }

    public static function ArrayProductoUpdate($request, $filename, $temporal, $username)
    {
        $urlproducto = Str::slug($request->nombreProducto);
        $estado = $request->chkEstadoProducto == "on" ? "1":"0";
        $oculto =0;
        if($temporal=="1"):
            $urlimagen = "assets/images/productos/".$filename;
        else:
            $urlimagen = $filename;
        endif;

        $data = [
            "categoria_id" => $request->categoriaProducto,
            "producto" =>$request->nombreProducto,
            "descripcion_producto" =>html_entity_decode($request->descripcion_producto),
            "imagen" => $urlimagen,
            "url" => $urlproducto,
            "estado" => $estado,
            "oculto" => $oculto,
            "usuario_registra" => $username
        ];

        return $data;
    }

    public static function existImagen($filename)
    {
        $url = public_path('assets/images/productos/'.$filename);
        echo ImageService::eliminarImg($url);
    }

    public static function moveImage($filename)
    {
        $destino =  public_path('assets/images/productos/');
        echo ImageService::moveimage($filename ,$destino);
    }

}