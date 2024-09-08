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
            'account_ID' => 'required|exists:accounts, account_ID',
            'supplier_name' => 'required',
            'supplier_address' => 'required',
            'supplier_email' => 'required',
            'supplier_contact_num' => 'required',
            'supplier_type' => 'required',
            'supplier_status' => 'required'
        ];
    }
}
