<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;




class LoginController extends Controller
{

    public function register (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100',
            'email'=> 'required|email|unique:usuarios,email',
            'password'=>'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $usuario = new Usuario();
        $usuario->nombre = $request->nombre;
        $usuario->email = $request->email;
        $usuario->password = Hash::make($request->password);
        $usuario->save();

        return redirect('login')
        ->with('type','success',)
        ->with('message','Usuario registrado exitosamente');
    }   


    public function check(Request $request) 
    {
           
            $credentials = $request->only('email', 'password');
            {

            if (Auth::attempt($credentials)) {
                return redirect()->intended('home')
                    ->with('type', 'success')
                    ->with('message', 'Bienvenido, ' . Auth::user()->nombre);
            }

            return redirect()->back()
                ->with('type', 'danger')
                ->with('message', 'Credenciales incorrectas, por favor intente de nuevo');
            
        }
    }
    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect('login')
            ->with('type', 'success')
            ->with('message', 'Has cerrado sesión exitosamente');
    }
}


