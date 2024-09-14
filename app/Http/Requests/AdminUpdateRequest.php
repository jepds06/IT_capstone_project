<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminUpdateRequest extends FormRequest
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
            'accountID' => 'required|exists:accounts,accountID',
            'adminFirstName' => 'required|string|max:255',
            'adminLastName' =>'required|string|max:255',
            'contactNum' => 'required|string|max:255',
            'adminAddress' => 'required|string|max:255'
        ];
    }
}
