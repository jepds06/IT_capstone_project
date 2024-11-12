<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReturnProdOrderUpdateRequest extends FormRequest
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
            'slsPrdOrdID' => 'required|integer|exists:salesProductOrders,slsPrdOrdID',
            'returnedDate' => 'required|date',
            'qtyReturned' => 'required|integer|min:1',
            'reason' => 'nullable|string|max:255',
            'refundAmount' => 'required|numeric|min:1'
        ];
    }
}
