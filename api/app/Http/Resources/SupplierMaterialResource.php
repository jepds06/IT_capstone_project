<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupplierMaterialResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'suppMatrlID' => $this->suppMatrlID,
            'supplierID' => $this->supplierID,
            'materialID' => $this->materialID,
            'unitPrice' => $this->unitPrice
        ];
    }
}
