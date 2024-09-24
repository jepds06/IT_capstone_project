<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupplierResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'supplierID' => $this->supplierID,
            'accountID' => $this->accountID,
            'supplierName' => $this->supplierName,
            'supplierAddress' => $this->supplierAddress,
            'supplierContactNum' => $this->supplierContactNum,
            'supplierContactPerson' => $this->supplierContactPerson,
            'supplierType' => $this->supplierType,
            'supplierStatus' => $this->supplierStatus
        ];
    }
}
