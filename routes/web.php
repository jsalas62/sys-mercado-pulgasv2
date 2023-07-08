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

Route::get('create-user', 'User\ClientController@create_user');
Route::Post('register-user', 'User\ClientController@register_user');

Route::Post('store-puja', 'PujaFrontController@storePuja');

Route::post('/comprobante/imgTmp', 'User\CierreSubastaCliente@imgTmp');

// links de recuperación de contraseña
Route::get('forget-password', 'ForgotPasswordController@showForgetPasswordForm')->name('forget.password.get');
Route::post('forget-password', 'ForgotPasswordController@submitForgetPasswordForm')->name('forget.password.post'); 
Route::get('reset-password/{token}', 'ForgotPasswordController@showResetPasswordForm')->name('reset.password.get');
Route::post('reset-password', 'ForgotPasswordController@submitResetPasswordForm')->name('reset.password.post');

Route::get('quienes-somos', 'FrontController@QuienesSomos');

Route::get('politicas-privacidad', 'FrontController@PoliticasPrivacidad');

Route::get('politicas-envio', 'FrontController@PoliticasEnvio');

Route::get('politicas-cambio', 'FrontController@PoliticasCambios');

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
    Route::get('misdatos', 'User\MyDataController@getData');
    Route::post('misdatos', 'User\MyDataController@postData');

    // Módulo Cambio de contraseña
    Route::get('contrasenia', 'User\MyPassController@getchangePassword');
    Route::post('contrasenia', 'User\MyPassController@changePassword');

    Route::resource('subastas', 'User\SubastaController',[ 'as' => 'user' ]);
    Route::post('subastas/finalizar/{id}', 'User\SubastaController@finalizar');
    Route::get('subastas/getDataGanador/{id}', 'User\SubastaController@getDataUserGanador');
    
    Route::get('pujas', 'User\PujaController@getMyPujas');
    Route::post('pujas/confirmarPujaRecepcion/{id}', 'User\PujaController@confirmarPujaRecepcion');

    Route::get('ver-pujas/{id}', 'User\PujaController@verPujasxSubata');
        
    Route::resource('cierre-subasta', 'User\CierreSubastaController',[ 'as' => 'user' ]);
    Route::post('cierre-subasta/aprobar/{id}', 'User\CierreSubastaController@aprobar');
    Route::post('cierre-subasta/rechazar/{id}', 'User\CierreSubastaController@rechazar');
    Route::post('cierre-subasta/confirmarRecepcion/{id}', 'User\CierreSubastaController@confirmar_recepcion');

    Route::get('cierre-subasta/getdatauser/{id}', 'User\CierreSubastaCliente@getDataUser');
    
    Route::get('crear-cierre/{id}', 'User\CierreSubastaCliente@createCierre')->name('user.crear-cierre');
    Route::post('crear-cierre', 'User\CierreSubastaCliente@postcierre')->name('user.crear-cierre');
      
});


Route::any('{catchall}', 'FrontController@get404NotFound')->where('catchall', '.*');