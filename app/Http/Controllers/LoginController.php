<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use function Pest\Laravel\json;

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

    function apiLogin(LoginRequest $login){
        $user = User::where('email', $login->email)->first(); //Buscar que el correo exista
        if(!isset($user)) return response()->json(["message" => 'No existe un usuario con ese correo'], 404);

        //Verificar que las contraseñas coincidan.
        $password = $login->password;
        if(!Hash::check($password, $user->password)) return response()->json(["message" => 'Las contraseñas no coinciden'], 404);

        //Crear token y devolverlo
        $token = $user->createToken('api-token');
        return response()->json(["token" => $token->plainTextToken]);
    }

    function revokeToken(Request $request){
        $request->user()->currentAccessToken()->delete();
        return true;
    }
}
