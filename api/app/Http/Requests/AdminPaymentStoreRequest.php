<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminPaymentStoreRequest extends FormRequest
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
            'adminOrdID' => 'required|integer|exists:adminOrders,adminOrdID', 
            'payMethodID' => 'required|integer|exists:paymentMethods,payMethodID', 
            'amountToPay' => 'required|numeric|min:0', 
            'amountPaid' => 'required|numeric|min:0', 
            'dueDate' => 'required|date|after_or_equal:today', 
            'paymentStatus' => 'required|string|in:pending,completed,cancelled',
            'remarks' => 'nullable|string|max:255', 
        ];
    }
}
