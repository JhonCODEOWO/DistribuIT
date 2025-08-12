<?php

namespace App\Http\Controllers\api;

use App\DTOs\UserRequestDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\api\UserUpdate;
use App\Models\User;
use App\Services\ImageService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
            path: 'api/users/update', 
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
            $newPath = $imageService->saveInto($request->file('profile_picture'), 'user_pictures');
            //Delete the last pathname in the server
            $imageService->deleteIfExists('user_pictures', $request->user()->profile_picture);

            //Realiza la actualización
            $requestDTO = new UserRequestDTO($request->all(), $newPath);
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
}
