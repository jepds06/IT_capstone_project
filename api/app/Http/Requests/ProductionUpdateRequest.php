<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductionUpdateRequest extends FormRequest
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
            'dateEncoded' => 'required|date',
            'year' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'month' => 'required|in:January,February,March,April,May,June,July,August,September,October,November,December',
            'remarks' => 'nullable|string|max:255',
            'status' => 'required|string|max:255'
        ];
    }
}
