<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $admin = Role::create(['name' => 'admin', 'estado' => '1', 'oculto' => '0']);

        Permission::create(['name' => 'admin.inicio', 'descripcion' => 'dashboard'])->syncRoles([$admin]);
        Permission::create(['name'=>'admin.categorias.index', 'descripcion' => 'Listado de Categorias'])->syncRoles([$admin]);
        Permission::create(['name'=>'admin.categorias.crear', 'descripcion' => 'Registro Categoría'])->syncRoles([$admin]);
        Permission::create(['name'=>'admin.categorias.actualizar', 'descripcion' => 'Actualizar Categoría'])->syncRoles([$admin]);
        Permission::create(['name'=>'admin.categorias.borrar', 'descripcion' => 'Eliminar Categoría'])->syncRoles([$admin]);
        Permission::create(['name'=>'admin.categorias.activar', 'descripcion' => 'Activar Categoría'])->syncRoles([$admin]);
        Permission::create(['name'=>'admin.categorias.desactivar', 'descripcion' => 'Desactivar Categoría'])->syncRoles([$admin]);

        Permission::create(['name'=>'admin.productos.index', 'descripcion' => 'Listado de Productos'])->syncRoles([$admin]);
        Permission::create(['name'=>'admin.productos.crear', 'descripcion' => 'Registro de Productos'])->syncRoles([$admin]);
        Permission::create(['name'=>'admin.productos.actualizar', 'descripcion' => 'Actualizar Productos'])->syncRoles([$admin]);
        Permission::create(['name'=>'admin.productos.borrar', 'descripcion' => 'Eliminar Productos'])->syncRoles([$admin]);
        Permission::create(['name'=>'admin.productos.activar', 'descripcion' => 'Activar Productos'])->syncRoles([$admin]);
        Permission::create(['name'=>'admin.productos.desactivar', 'descripcion' => 'Desactivar Productos'])->syncRoles([$admin]);

        Permission::create(['name'=>'admin.roles.index', 'descripcion' => 'Listado de Roles'])->syncRoles([$admin]);
        Permission::create(['name'=>'admin.roles.crear', 'descripcion' => 'Registro de Rol'])->syncRoles([$admin]);
        Permission::create(['name'=>'admin.roles.actualizar', 'descripcion' => 'Actualizar Rol'])->syncRoles([$admin]);
        Permission::create(['name'=>'admin.roles.borrar', 'descripcion' => 'Eliminar Rol'])->syncRoles([$admin]);
        Permission::create(['name'=>'admin.roles.activar', 'descripcion' => 'Activar Rol'])->syncRoles([$admin]);
        Permission::create(['name'=>'admin.roles.desactivar', 'descripcion' => 'Desactivar Rol'])->syncRoles([$admin]);
    }
}
