<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeveloperResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
          'id'      => $this->id,
          'name'    => $this->name,
          'gender'  => $this->gender,
          'birth_date' => $this->birth_date,
          'age'     => $this->age,
          'hobby'   => $this->hobby,
          'level'   =>  $this->Level, /*hasOne no model Developer*/
        ];
    }
}
