<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalesDeliveryStoreRequest extends FormRequest
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
            'deliveryDate' => 'required|date',
            'deliveryAddress' => 'required|string|max:255',
            'deliveryStatus' => 'nullable|string|max:255'
        ];
    }
}