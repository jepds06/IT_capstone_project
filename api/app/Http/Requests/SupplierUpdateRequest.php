<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierUpdateRequest extends FormRequest
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
            'accountID' => 'required|integer|exists:accounts,accountID',
            'supplierName' => 'required|string|max:255',
            'supplierAddress' => 'required|string|max:255',
            'supplierContactNum' => 'required|string|max:255',
            'supplierContactPerson' => 'required|string|max:255',
            'supplierType' => 'required|string|max:255',
            'supplierStatus' => 'required|string|max:255'
        ];
    }
}
