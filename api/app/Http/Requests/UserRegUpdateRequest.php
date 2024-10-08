<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegUpdateRequest extends FormRequest
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
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'userName' => 'required|string|max:255|unique:users,userName',
            'email' => 'required|string|email|max:255|unique:users,email',
            'email_verified_at' => 'nullable|date',
            'password' => 'nullable|string|min:8',
            'userTypeID' => 'required|integer|exists:userTypes,userTypeID', // Assuming 'user_types' is the related table for user types
            'remember_token' => 'nullable|string|max:100',
        ];
    }
}
