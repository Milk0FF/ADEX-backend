<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
            'comment'       => $this->comment,
            'score'         => $this->scoreType->name,
            'task'          => new TaskResource($this->task),
            'author'        => new UserResource($this->author),
            'customer'      => new UserResource($this->customer),
            'executor'      => new UserResource($this->executor),
            'created_at'    => date('d.m.Y', strtotime($this->created_at)),
        ];
    }
}
