<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'adminID' => $this->adminID,
            'accountID' => $this->accountID,
            'adminFirstName' => $this->adminFirstName,
            'adminLastName' => $this->adminLastName,
            'contactNum' => $this->contactNum,
            'adminAddress' => $this->adminAddress
        ];
    }
}
