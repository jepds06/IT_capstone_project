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
            'account_ID' => 'required|exists:accounts, account_ID',
            'admin_first_name' => 'required|string|max:255',
            'admin_last_name' =>'required|string|max:255',
            'contact_num' => 'required|string|max:255',
            'admin_address' => 'required|string|max:255'
        ];
    }
}
