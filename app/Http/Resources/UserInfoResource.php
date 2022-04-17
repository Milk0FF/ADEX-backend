<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $avatar = null;
        if($this->avatar)
            $avatar = $this->avatar()->url;
        return [
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'about' => $this->about,
            'phone' => $this->phone,
            'living_place' => $this->living_place,
            'rating' => $this->rating,
            'employment_type' => $this->employmentType()->name,
            'avatar' => $this->avatar,
        ];
    }
}
