<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductMaterialsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'productMatsID' => $this->productMatsID,
            'productID' => $this->productID,
            'materialID' => $this->materialID,
            'quantity' => $this->quantity
        ];
    }
}
