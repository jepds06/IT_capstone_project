<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerPaymentUpdateRequest extends FormRequest
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
            'paymentDate' => 'required|date',
            'payMethodID' => 'required|integer|exists:paymentMethods,payMethodID',
            'paymentStatus' => 'required|string|max:255',
            'dueDate' => 'required|date',
            'amountToPay' => 'required|numeric|min:1',
            'amountPaid' => 'required|numeric|min:0'
        ];
    }
}
