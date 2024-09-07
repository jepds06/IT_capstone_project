<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerUpdateRequest extends FormRequest
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
            'cstr_first_name' => 'required|string|max:255',
            'cstr_last_name' => 'required|string|max:255',
            'contact_num' => 'required|string|max:255',
            'cstr_address' => 'required|string|max:255',
            'customer_type' => 'required|string|max:255',
            'pref_contact_method' => 'required|string|max:255',
            'cstr_status' => 'required|string|max:255'
        ];
    }
}
