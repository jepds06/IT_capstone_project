<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'customerID' => $this->customerID,
            'accountID' => $this->accountID,
            'cstrFirstName' => $this->cstrFirstName,
            'cstrLastName' => $this->cstrLastName,
            'contactNum' => $this->contactNum,
            'cstrAddress' => $this->cstrAddress,
            'customerType' => $this->customerType,
            'prefContactMethod' => $this->prefContactMethod,
            'cstrStatus' => $this->cstrStatus
        ];
    }
}
