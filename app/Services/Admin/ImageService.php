<?php
namespace App\Services\Admin;
 

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class ImageService
{
    public static function subirImagenTmp($request)
    {
        $pathtmp = public_path('assets/images/tmp/');
        $fileNames = time().'_'.$request->indice.'_'.$request->imagen->getClientOriginalName();
        $sizefiles = $request->imagen->getSize();
        $urlfiles = "assets/images/tmp/".$fileNames;
        if (!file_exists($pathtmp)):
            mkdir($pathtmp, 0777, true);
        endif;

        $request->imagen->move($pathtmp, $fileNames);

        $data = [
            "name" => $fileNames,
            "size"=> $sizefiles,
            "url"=>$urlfiles,
        ];

        return $data;
    }

    public static function eliminarImagenTmp($request)
    {
        if( File::exists(public_path('assets/images/tmp/'.$request->filename))):
            File::delete(public_path('assets/images/tmp/'.$request->filename));
        endif;

        return true;
    }

    public static function moveimage($filename, $destino)
    {
        $origen = public_path('assets/images/tmp');

        if (!file_exists($destino)):
            mkdir($destino, 0777, true);
        endif;
        copy($origen.'/'.$filename, $destino.'/'.$filename);
        unlink($origen.'/'.$filename);
    }

    public static function eliminarImg($url)
    {
        if( File::exists($url)):
            File::delete($url);
        endif;
        // return true;
    }
    

}