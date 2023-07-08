<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB, Validator;
use Carbon\Carbon; 
use App\Models\User; 
use Mail; 
use Hash;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    //muestra la vista ed recuperacion, ingresar correo
    public function showForgetPasswordForm()
    {
       return view('olvideContrasenia');
    }

    //envia correo
    public function submitForgetPasswordForm(Request $request)
    {
        $rules = [  
            'email' => 'required|email|exists:users',
        ];

        $messages = [
            'email.required ' => 'El campo Email es requerido',
            'email.email' => 'El formato de Correo no es válido',
            'email.exists' => 'El Correo Electrónico no existe',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        
        if($validator->fails()):
            return back()->withErrors($validator);
        else:

            $existToken = DB::table('password_reset_tokens')
                            ->where([
                            'email' => $request->email
                            ])
                            ->first();

            if($existToken){
                return back()->with('message', '¡Ya se ha enviado al correo electrónico, el link para reestablecer la Contraseña!');
            }

            $token = Str::random(64);
            DB::table('password_reset_tokens')->insert([
                'email' => $request->email, 
                'token' => $token, 
                'created_at' => Carbon::now()
              ]);

            Mail::send('email.forgetPassword', ['token' => $token], function($message) use($request){
                $message->to($request->email);
                $message->subject('Cambio de Contraseña');
            });

            return back()->with('message', '¡Le hemos enviado por correo electrónico su enlace de restablecimiento de contraseña!');
        
        endif;
        // $request->validate([
        //     'email' => 'required|email|exists:users',
        // ]);

    }

    //muestra el formulario de cambio de contraseña
    public function showResetPasswordForm($token) { 

        $validateToken = DB::table('password_reset_tokens')
                    ->where([
                    'token' => $token
                    ])
                    ->first();

        if(!$validateToken){
            return redirect('/');
        }

        return view('recordarPasswordLink', ['token' => $token]);
     }

     //cambia la contraseña
     public function submitResetPasswordForm(Request $request)
     {
        $rules = [  
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|min:8|same:password'
        ];

        $messages = [
            'email.required ' => 'El campo Email es requerido',
            'email.email' => 'El formato de Correo no es válido',
            'email.exists' => 'El Correo Electrónico no existe',
            'password.required' => 'La Contraseña es requerida',
            'password.min' => 'La contraseña debe contener al menos 8 carácteres',
            'password.confirmed' => 'La confirmación del campo de contraseña no coincide.',
            'password_confirmation.required' => 'Es necesario confirmar la contraseña',
            'password_confirmation.min' => 'La confirmación de contraseña debe contener al menos 8 carácteres',
            'password_confirmation.same' => 'Las contraseñas no coinciden.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        
        if($validator->fails()):
            return back()->withErrors($validator);
        else:

        //  $request->validate([
        //      'email' => 'required|email|exists:users',
        //      'password' => 'required|string|min:6|confirmed',
        //      'password_confirmation' => 'required'
        //  ]);
    
            $updatePassword = DB::table('password_reset_tokens')
                                ->where([
                                'email' => $request->email, 
                                'token' => $request->token
                                ])
                                ->first();
    
            if(!$updatePassword){
                return back()->withInput()->with('error', 'Token Inválido!');
            }
    
            $user = User::where('email', $request->email)
                        ->update(['password' => Hash::make($request->password)]);

            DB::table('password_reset_tokens')->where(['email'=> $request->email])->delete();
    
            return redirect('/login')->with('message2','Se ha actualizado la Contraseña!');

        endif;
     }
}
