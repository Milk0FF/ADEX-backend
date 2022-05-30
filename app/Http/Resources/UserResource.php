<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $userInfo = $this->userInfo;
        $avatar = null;
        if($userInfo->avatar)
            $avatar = $userInfo->avatar->url;
        return [
            'id'        => $this->id,
            'username'  => $this->username,
            'firstname' => $userInfo->firstname,
            'lastname'  => $userInfo->lastname,
            'avatar'    => url($avatar),
        ];
    }
}
