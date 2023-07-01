<?php
namespace App\Services\Admin;
 
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB, Validator,Hash;

//exportar modelo roles de spattie
use Spatie\Permission\Models\Role; 

class RoleService
{
    public static function getRoles($rol, $estado)
    {
        $roles = Role::select('id','name', 'estado', 'oculto');

        if (isset($rol) && $rol != ''):
            $roles ->where('name','LIKE','%'.$rol."%");
        endif;   

        if (isset($estado) && $estado!='_all_'):

            $roles->where('estado',$estado);
        endif;

        $roles= $roles->where('oculto',0)
                        ->orderBy('name','ASC')->paginate(10);

        return $roles;
    }

    public static function addArrayRole($request)
    {
        $estado = $request->chkEstadoRol == "on" ? "1":"0";

        $data = [
            'name' => $request->nombreRol,
            'estado' => $estado,
            'oculto' => 0
        ]; 

        return $data;
    }

    public static function getPermisosByrol($id)
    {
        $data = DB::table('role_has_permissions')->where('role_id', $id)->pluck('permission_id')->toArray();

        return $data;
    }

    public static function DeletePermissionsByRol($id)
    {
        $deleted = DB::table('role_has_permissions')->where('role_id', $id)->delete();
    }
     
    public static function deleteRol($id)
    {
        $delete_rol = DB::table('roles')->where('id',$id)->delete();
    }
}