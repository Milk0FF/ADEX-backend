<?php

namespace App\Http\Resources;

use App\Models\Review;
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
        if($this->avatar){
            $avatar = url($this->avatar->url);
        }
        $user = $this->user;
        $successReviews = null;
        $failedReviews = null;
        if($user->user_type_id === 1){
            $successReviews = Review::where('executor_id', $user->id)->where('author_id', '!=', $user->id)->where('score_type_id', 1)->get()->count();
            $failedReviews = Review::where('executor_id', $user->id)->where('author_id', '!=', $user->id)->where('score_type_id', 2)->get()->count();
        }
        else{
            $successReviews = Review::where('customer_id', $user->id)->where('author_id', '!=', $user->id)->where('score_type_id', 1)->get()->count();
            $failedReviews = Review::where('customer_id', $user->id)->where('author_id', '!=', $user->id)->where('score_type_id', 2)->get()->count();
        }
        return [
            'id'                => $this->id,
            'firstname'         => $this->firstname,
            'lastname'          => $this->lastname,
            'about'             => $this->about,
            'phone'             => $this->phone,
            'email'             => $this->user->email,
            'city'              => $this->city,
            'country'           => $this->country,
            'birth_date'        => $this->birth_date,
            'rating'            => $this->rating,
            'avatar'            => $avatar,
            'success_reviews'   => $successReviews,
            'failed_reviews'    => $failedReviews,
            'user_type'         => $user->user_type_id,
            'employment_type'   => $this->employmentType ? StatusResource::make($this->employmentType) : null,
            'categories'        => StatusResource::collection($this->user->categoryWorks),
            'created_at'        => $this->created_at,
        ];
    }
}
