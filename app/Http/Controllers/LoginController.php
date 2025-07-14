<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use OpenApi\Attributes as OAT;

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

    /**
     * Make a user login retrieving the PersonalAccessToken
     */
    #[OAT\Post(
        path: '/api/auth/login',
        description: 'Endpoint to get a PersonalAccessToken with credentials.',
        requestBody: new OAT\RequestBody(
            content: new OAT\JsonContent(
                required: ['email', 'password'],
                properties: [
                    new OAT\Property(
                        property: 'email',
                        type: 'string',
                        description: 'Email of the user',
                        example: 'correo@correo.com'
                    ),
                    new OAT\Property(
                        property: 'password',
                        type: 'string',
                        description: 'The password of the user',
                        example: 'abc123'
                    ),
                ]
            ),
            description: 'Email and password to make the login'
        ),
        responses: [
            new OAT\Response(
                description: 'Credentials are correctly and token is retrieved',
                content: new OAT\JsonContent(
                    properties: [new OAT\Property(property: 'token', description: 'Personal access token', example: '1|bZmu4nZqCViOqg7i9JL5LwYlRvl24HkP9uDdeLfO')]
                ),
                response: 200,
            )
        ],
        tags: ['auth']
    )]
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

    /**
     * Revoke a PersonalAccessToken
     */
    #[OAT\Delete(
        path: '/api/auth/logout',
        description: 'Revoke the token from the server of the user that makes the request',
        responses: [
            new OAT\Response(
                content: new OAT\JsonContent(example: true),
                response: 200,
                description: 'The token has been revoked correctly'
            )
        ],
        tags: ['auth']
    )]
    function revokeToken(Request $request){
        $request->user()->currentAccessToken()->delete();
        return true;
    }
}
