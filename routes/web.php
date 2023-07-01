<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', 'FrontController@showIndex')->name('index');

Route::get('categorias/{url}', 'FrontController@getCategoriaFront');

Route::get('productos', 'FrontController@getProductsFront');

Route::get('producto/{url}', 'FrontController@getProductFront');

Route::post('producto/fin_subasta', 'FrontController@postFinSubasta');


Route::get('login', 'LoginController@getLogin')->name('login');
Route::Post('login', 'LoginController@postLogin')->name('login');
Route::get('logout', 'LoginController@getLogout')->name('logout');

Route::Post('register-user', 'User\ClientController@register_user');

Route::Post('store-puja', 'PujaFrontController@storePuja');


Route::prefix('user')->group(function () {

    Route::get('account', 'DashboardController@getDashboard')->name('user.dashboard');
    Route::resource('categorias', 'User\CategoriaController');
    Route::post('categorias/activar/{id}', 'Admin\CategoriaController@activar');
    Route::post('categorias/desactivar/{id}', 'Admin\CategoriaController@desactivar');

    Route::resource('productos', 'User\ProductoController', [ 'as' => 'user' ]);
    Route::post('productos/activar/{id}', 'User\ProductoController@activar');
    Route::post('productos/desactivar/{id}', 'User\ProductoController@desactivar');
    Route::post('productos/subirImagenTmp', 'User\ProductoController@subirImagenTmp');
    Route::post('productos/eliminarImagenTmp', 'User\ProductoController@eliminarImagenTmp');
    Route::post('productos/eliminarImagen', 'User\ProductoController@eliminarImagen');
    Route::post('productos/eliminarImagen/{key}', 'User\ProductoController@deleteImagen');

    // Módulo Roles
    Route::resource('roles', 'User\RolController',[ 'as' => 'user' ]);
    Route::post('roles/activar/{id}', 'User\RolController@activar');
    Route::post('roles/desactivar/{id}', 'User\RolController@desactivar');

      //Módulo Usuarios
    Route::resource('usuarios', 'User\UserController',[ 'as' => 'user' ]);
    Route::post('usuarios/activar/{id}', 'User\UserController@activar');
    Route::post('usuarios/desactivar/{id}', 'User\UserController@desactivar');
    Route::post('usuarios/subirImagenTmp', 'User\UserController@subirImagenTmp');
    Route::post('usuarios/eliminarImagenTmp', 'User\UserController@eliminarImagenTmp');
    Route::post('usuarios/eliminarFoto', 'User\UserController@eliminarFoto');

    // Módulo Datos
    Route::get('misdatos', 'User\UserController@getData');
    Route::post('misdatos', 'User\UserController@postData');

    // Módulo Cambio de contraseña
    Route::get('contrasenia', 'User\UserController@getchangePassword');
    Route::post('contrasenia', 'User\UserController@changePassword');

    Route::resource('subastas', 'User\SubastaController',[ 'as' => 'user' ]);
    Route::post('subastas/finalizar/{id}', 'User\SubastaController@finalizar');
    
    Route::get('pujas', 'User\PujaController@getMyPujas');

    Route::get('ver-pujas/{id}', 'User\PujaController@verPujasxSubata');
        
    Route::resource('cierre-subasta', 'User\CierreSubastaController',[ 'as' => 'user' ]);
    Route::get('crear-cierre/{id}', 'User\CierreSubastaController@createCierre')->name('user.crear-cierre');;
      
});

Route::prefix('admin')->group(function () {

    Route::get('/login', 'Admin\LoginAdminController@getLogin')->name('login2');
    Route::Post('/login', 'Admin\LoginAdminController@postLogin')->name('admin.login');
    Route::get('/logout', 'Admin\LoginAdminController@getLogout')->name('logout');

    Route::get('/', 'Admin\DashboardController@getDashboard')->name('admin.dashboard');
    // Módulo Categorías
    Route::resource('categorias', 'Admin\CategoriaController');
    Route::post('categorias/activar/{id}', 'Admin\CategoriaController@activar');
    Route::post('categorias/desactivar/{id}', 'Admin\CategoriaController@desactivar');
    // Módulo Productos
    Route::resource('productos', 'Admin\ProductoController', [ 'as' => 'admin' ]);
    Route::post('productos/activar/{id}', 'Admin\ProductoController@activar');
    Route::post('productos/desactivar/{id}', 'Admin\ProductoController@desactivar');
    Route::post('productos/subirImagenTmp', 'Admin\ProductoController@subirImagenTmp');
    Route::post('productos/eliminarImagenTmp', 'Admin\ProductoController@eliminarImagenTmp');
    Route::post('productos/eliminarImagen', 'Admin\ProductoController@eliminarImagen');
    Route::post('productos/eliminarImagen/{key}', 'Admin\ProductoController@deleteImagen');
    // Módulo Roles
    Route::resource('roles', 'Admin\RolController',[ 'as' => 'admin' ]);
    Route::post('roles/activar/{id}', 'Admin\RolController@activar');
    Route::post('roles/desactivar/{id}', 'Admin\RolController@desactivar');
    //Módulo Usuarios
    Route::resource('usuarios', 'Admin\UserController',[ 'as' => 'admin' ]);
    Route::post('usuarios/activar/{id}', 'Admin\UserController@activar');
    Route::post('usuarios/desactivar/{id}', 'Admin\UserController@desactivar');
    Route::post('usuarios/subirImagenTmp', 'Admin\UserController@subirImagenTmp');
    Route::post('usuarios/eliminarImagenTmp', 'Admin\UserController@eliminarImagenTmp');
    Route::post('usuarios/eliminarFoto', 'Admin\UserController@eliminarFoto');

});