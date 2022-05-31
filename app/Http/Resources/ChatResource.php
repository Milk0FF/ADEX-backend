<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'customer'      => new UserResource($this->customer),
            'executor'      => new UserResource($this->executor),
            'task'          => new TaskResource($this->task),
            'created_at'    => date('d.m.Y', strtotime($this->created_at)),
        ];
    }
}
