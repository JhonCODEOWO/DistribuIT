<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_picture'
    ];

    protected $appends = ['profile_picture_url'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    function products(){
        return $this->hasMany(Product::class);
    }

    function sales(){
        return $this->hasMany(Sale::class);
    }

    protected function profilePictureUrl():Attribute{
        return Attribute::make(
            get: fn(mixed $values, array $attributes) => env('APP_URL').Storage::url('user_pictures/'.$attributes['profile_picture'])
        );
    }

    //Propiedad que aplica un mutador para almacenar en minúscula cualquier string y devolver cada palabra en mayúscula
    protected function name(): Attribute{
        return Attribute::make(
            get: fn(string $name) => ucwords($name),
            set: fn(string $name) => strtolower($name)
        );
    }

    // protected function profileEmail(): Attribute{
    //     return Attribute::make(
    //         get: fn(mixed $value, array $attributes) => $attributes['name'].' - '.$attributes['email']
    //     );
    // }
}
