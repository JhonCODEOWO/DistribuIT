<?php

namespace App\DTOs;
use OpenApi\Attributes as OAT;

#[OAT\Schema(
    title: 'UserRequestDTO',
    schema: 'user_request',
    description: 'DTO to make request related with users'
)]
class UserRequestDTO {
    #[OAT\Property(nullable: true, example: 'John Gonzales Luna',minLength: 6)]
    private ?string $name;
    #[OAT\Property(nullable: true, example: 'correo@correo.com', minLength: 5)]
    private ?string $email;
    #[OAT\Property(nullable: true, example: '')]
    private ?string $email_verified_at;
    #[OAT\Property(nullable: true, minLength: 8, example: 'root12345')]
    private ?string $password;
    private ?string $profile_picture;
    
    function __construct(array $reqData, ?string $profile_picture = null){
        $this->name = $reqData['name'] ?? null;
        $this->email = $reqData['email'] ?? null;
        $this->email_verified_at = $reqData['email_verified_at'] ?? null;
        $this->password = $reqData['password'] ?? null;
        $this->profile_picture = $profile_picture ?? null;
    }

    public function getUserData(): array
    {
        $userData = array();
        $userData['name'] = $this->name;
        $userData['email'] = $this->email;
        $userData['email_verified_at'] = $this->email_verified_at;
        $userData['password'] = $this->password;
        $userData['profile_picture'] = $this->profile_picture;

        return array_filter($userData, fn($item) => !is_null($item));
    }
}