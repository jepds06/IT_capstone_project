<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'productID' => $this->productID,
            'productName' => $this->productName,
            'specifications' => $this->specifications,
            'unitPrice' => $this->unitPrice,
            'prodCatID' => $this->prodCatID
        ];
    }
}
