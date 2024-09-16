<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'accountID' => $this->accountID,
            'username' => $this->username,
            'email' => $this->email,
            'password' => $this->password,
            'accTypeID' => $this->accTypeID
        ];
    }
}
