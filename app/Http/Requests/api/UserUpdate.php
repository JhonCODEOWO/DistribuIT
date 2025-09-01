<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'nullable|string|min:6',
            'email' => 'nullable|email|unique:users,email,'.$this->user()->id,
            'password' => 'nullable|string|min:8',
            'password_confirmation' => 'nullable|string|confirmed:password|min:8',
            'profile_picture' => 'nullable|file|mimes:jpg'
        ];
    }
}
