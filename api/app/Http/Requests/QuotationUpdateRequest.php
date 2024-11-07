<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuotationUpdateRequest extends FormRequest
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
            'quotationDate' => 'required|date',
            'userID' => 'required|integer|exists:users,userID',
            'productionID' => 'required|integer|exists:productions,productionID',
            'remarks' => 'required|string|max:255',
            'isCompleted' => 'required|boolean'
        ];
    }
}
