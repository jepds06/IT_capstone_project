<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalesProdOrderStoreRequest extends FormRequest
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
            'salesID' => 'required|integer|exists:sales,salesID',
            'productID' => 'required|integer|exists:products,productID',
            'qtyOrdered' => 'required|integer|min:1',
            'amount' => 'required|numeric|min:1'
        ];
    }
}
