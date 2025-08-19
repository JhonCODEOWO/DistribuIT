<?php

namespace App\Http\Controllers\api;

use App\DTOs\UserDTO;
use App\DTOs\UserRequestDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\api\UserCreate;
use App\Http\Requests\api\UserUpdate;
use App\Models\User;
use App\Services\ImageService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use OpenApi\Attributes as OAT;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Create a new user
     */
        #[OAT\Post(
            tags: ['users'], 
            path: '/api/users/store', 
            description: 'Create a new user in the database', 
            responses: [
                new OAT\Response(response: 200, description: 'User created', content: new OAT\JsonContent(ref: '#/components/schemas/user_response')),
                new OAT\Response(response: 500, description: 'Unexpected error, notify to the developer')
            ],
            requestBody: new OAT\RequestBody(
                description: 'Data to create a user',
                required: true,
                content: new OAT\JsonContent(ref: '#/components/schemas/user_request')
            ),
        )
    ]
    public function store(UserCreate $request, ImageService $imageService)
    {
        DB::beginTransaction();
        try {
            //Save profile_picture
            $path = $imageService->saveInto($request->file('profile_picture'), 'user_pictures');
            $userDTO = new UserRequestDTO($request->validated(), $path);
            $user = User::create($userDTO->getUserData());
            DB::commit();
            return new UserDTO($user);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            DB::rollBack();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    #[OAT\Patch(
            tags: ['users'], 
            path: '/api/users/update', 
            description: 'Make an user update and remove the token of the user', 
            responses: [
                new OAT\Response(response: 200, description: 'User update success', content: new OAT\JsonContent(type: 'boolean', example: 1)),
                new OAT\Response(response: 401, description: 'The user must be authenticated')
            ],
            requestBody: new OAT\RequestBody(
                description: 'Data to update in the user',
                required: true,
                content: new OAT\JsonContent(ref: '#/components/schemas/user_request')
            ),
        )
    ]
    /**
     * Update a user and remove the current token
     */
    public function update(UserUpdate $request, ImageService $imageService)
    {
        DB::beginTransaction();
        try {
            //Store the file uploaded to the server
            if(isset($request->profile_picture)) {
                $newPath = $imageService->saveInto($request->file('profile_picture'), 'user_pictures');
                //Delete the last pathname in the server
                $imageService->deleteIfExists('user_pictures', $request->user()->profile_picture);
            }

            //Realiza la actualización
            $requestDTO = new UserRequestDTO($request->all(), $newPath ?? null);
            $success = $request->user()->update($requestDTO->getUserData());
            Db::commit();

            //Elimina el token para forzar a iniciar sesión.
            $request->user()->currentAccessToken()->delete();
            
            return $success;
        } catch (Exception $ex) {
            DB::rollBack();
            abort(500, $ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    #[OAT\Get(
            tags: ['validators'], 
            path: '/api/users/verifyEmail/{email}', 
            description: 'Check if the user given exists already in users.', 
            responses: [
                new OAT\Response(response: 200, description: 'Result of evaluation', content: new OAT\JsonContent(type: 'boolean')),
                new OAT\Response(response: 500, description: 'Unexpected error, notify to the developer')
            ],
            parameters: [
                new OAT\Parameter(in: 'path', example: 'prueba@prueba.com', name:'email')
            ]
    )]
    public function checkEmailTaken(string $email): bool{
        $exists = User::where('email', $email)->exists();
        return $exists;
    }
}
