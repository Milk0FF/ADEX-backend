<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // $countDateend
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'description'       => $this->description,
            'price'             => $this->price,
            'views'             => $this->views,
            'status'            => $this->status,
            'date_end'          => $this->date_end,
            // 'count_date_end'    => $this->date_end,
            'categories'        => CategoryWorksResource::collection($this->categoryWorks),
            'customer_id'       => $this->customer_id,
            'executor_id'       => $this->executor_id,
            'created_at'        => $this->created_at,
        ];
    }
}
