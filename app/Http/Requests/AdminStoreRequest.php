<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminStoreRequest extends FormRequest
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
            'admin_first_name' => 'required',
            'admin_last_name' =>'required',
            'contact_num' => 'nullable',
            'admin_address' => 'required'
        ];
    }
}
