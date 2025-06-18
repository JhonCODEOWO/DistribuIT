<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    function index()
    {
        return view('auth/login');
    }

    function login(LoginRequest $login)
    {
        if (Auth::attempt($login->only('email', 'password'))) {

            $login->session()->regenerate();
            return redirect()->intended('');
        }

        return back()->withErrors(["error" => 'Error al iniciar sesión, verifica los datos']);
    }

    function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('auth.login');
    }
}
