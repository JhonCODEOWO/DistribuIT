<?php

namespace App\DTOs;

use App\Models\User;
use OpenApi\Attributes as OAT;

#[OAT\Schema(
    title: 'UserDTO',
    schema: 'user_response',
    description: 'Response of a user in each request related to it',
    type: 'object'
)]
class UserDTO
{
    #[OAT\Property(description: 'ID of the user', example: 1)]
    public int $id;
    #[OAT\Property(description: 'Name of user', example: 'John Torres')]
    public string $name;
    #[OAT\Property(description: 'Email of user', example: 'correo@correo.com')]
    public string $email;
    #[OAT\Property(description: 'URL to profile picture', example: 'http://example/example.jpg')]
    public string $profile_picture;
    #[OAT\Property(description: 'Date of creation', example: '2025-07-02 18:38:46')]
    public string $created_at;
    #[OAT\Property(description: 'Date of the las update', example: '2025-07-02 18:38:46')]
    public string $updated_at;
    /**
     * SAssign data to retrieve.
     */
    public function __construct(User $user)
    {
        $this->id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->profile_picture = $user->profile_picture_url;
        $this->created_at = $user->created_at;
        $this->updated_at = $user->updated_at;
    }
}
