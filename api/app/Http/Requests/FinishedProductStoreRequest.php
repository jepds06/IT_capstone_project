<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FinishedProductStoreRequest extends FormRequest
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
            'prodtnDetailID' => 'required|integer|exists:productionDetails,prodtnDetailID',
            'productionDate' => 'required|date',
            'quantity' => 'required|integer|min:1',
            'unitPrice' => 'required|numeric',
            'status' => 'required|string|max:255',
            'remarks' => 'required|string|max:255'
        ];
    }
}
