<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modo extends Model
{
    use HasFactory;

    protected $table = 'modos';

    protected $primaryKey = 'modo_id';

    protected $fillable = ['modalidad','estado'];

    public static function getListModos()
    {
        $valor = Modo::where('estado',1)->get();

        return $valor;
    }
}
