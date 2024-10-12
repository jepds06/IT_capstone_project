<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuotationDetailUpdateRequest extends FormRequest
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
            'quoteID' => 'required|integer|exists:quotations,quoteID',
            'prodtnMtrlID' => 'required|integer|exists:productionMaterials,prodtnMtrlID',
            'quantity' => 'required|integer|min:1',
            'quotePrice' => 'required|numeric'
        ];
    }
}
