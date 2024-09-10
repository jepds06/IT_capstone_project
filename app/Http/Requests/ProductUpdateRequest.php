<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
            'productName' => 'required|string|max:255',
            'specifications' => 'required|string|max:255',
            'unitPrice' => 'required|string|max:255',
            'prodCatID' => 'required|exists:productCategories, prodCatID'
        ];
    }
}
