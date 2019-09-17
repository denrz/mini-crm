<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Employee extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => [
                'employee_id' => $this->id,
                'company_id' => intval($this->company_id),
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'company' => $this->company->name,
                'email' => $this->email,
                'phone' => $this->phone
            ],
            'links' => [
                'self' => $this->path()
            ]
        ];
    }
}
