<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerStoreRequest extends FormRequest
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
            'cstrFirstName' => 'required|string|max:255',
            'cstrLastName' => 'required|string|max:255',
            'contactNum' => 'required|string|max:255',
            'cstrAddress' => 'required|string|max:255',
            'customerType' => 'required|string|max:255',
            'prefContactMethod' => 'required|string|max:255',
            'cstrStatus' => 'required|string|max:255'
        ];
    }
}
