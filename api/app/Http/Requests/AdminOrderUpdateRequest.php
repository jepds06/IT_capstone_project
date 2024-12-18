<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminOrderUpdateRequest extends FormRequest
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
            'userID' => 'required|integer|exists:users,userID', 
            'quoteID' => 'required|integer|exists:quotations,quoteID',
            'orderDate' => 'required|date',
            'isApproved' => 'required|boolean',
        ];
    }
}
