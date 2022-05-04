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
        if($this->avatar)
            $avatar = $this->avatar->url;
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
            'city'              => $this->city,
            'country'           => $this->country,
            'rating'            => $this->rating,
            'employment_type'   => $this->employmentType ? $this->employmentType->name : null,
            'avatar'            => url($avatar),
            'success_reviews'   => $successReviews,
            'failed_reviews'    => $failedReviews,
            'created_at'        => $this->created_at,
        ];
    }
}
