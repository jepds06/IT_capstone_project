<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MaterialResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'materialID' => $this->materialID,
            'description' => $this->description,
            'specification' => $this->specification,
            'brand' => $this->brand,
            'unitOfMeasure' => $this->unitOfMeasure
        ];
    }
}
