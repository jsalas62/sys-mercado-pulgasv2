<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles, HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = 'users';

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'nombres',
        'apellidos',
        'usuario',
        'email',
        'password',
        'telefono',
        'direccion',
        'foto',
        'estado',
        'oculto',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public static function getUsers($nusuario = '', $estado = '_all_')
    {
        $usuarios= User::select('users.*','r.name as rol')
                    ->join('model_has_roles as mr', function($join)
                    {
                        $join->on('users.user_id', '=', 'mr.model_id');
                    })
                    ->join('roles as r', function($join)
                    {
                        $join->on('mr.role_id', '=', 'r.id');
                    });

        if (isset($nusuario) && $nusuario != ''):
            $usuarios->where('users.nombres','LIKE','%'.$nusuario.'%')
                     ->orWhere('users.apellidos','LIKE','%'.$nusuario.'%');
        endif;  

        if (isset($estado) && $estado != '_all_'):
            $usuarios->where('users.estado',$estado);
        endif;  

        $usuarios = $usuarios->where('users.oculto',0)
                    ->orderBy('users.apellidos', 'ASC')
                    ->paginate(10);

        return $usuarios;
    }
}
