<?php

namespace App\Http\Resources;

use Carbon\Carbon;
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
        $countDateEnd = Carbon::parse($this->date_end)->diff(Carbon::now())->format('%d');
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'description'       => $this->description,
            'price'             => $this->price,
            'views'             => $this->views,
            'status'            => $this->status,
            'date_end'          => $this->date_end,
            'count_date_end'    => $countDateEnd,
            'categories'        => CategoryWorksResource::collection($this->categoryWorks),
            'customer_id'       => $this->customer_id,
            'executor_id'       => $this->executor_id,
            'created_at'        => $this->created_at,
        ];
    }
}
