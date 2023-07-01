<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias';

    protected $primaryKey = 'categoria_id';

    protected $fillable = ['categoria','descripcion','url','estado','oculto'];
    
    public static function getCategoryExits($slug)
    {
        $categoria =  Categoria::where('url',$slug)->where('oculto',0)->count();

        return $categoria;
    }

    public static function getCategoryList()
    {
        $categoria =  Categoria::where('estado',1)->where('oculto',0)->get();

        return $categoria;
    }

    public static function getCategoriaTitleFront($url)
    {
        $data = Categoria::select('categoria_id','categoria','url')
                ->where('url',$url)->where('oculto',0)->first();

        return $data;
    }

}
