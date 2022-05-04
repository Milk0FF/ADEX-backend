<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Review\CreateReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use App\Models\Task;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    //Получение отзывов о пользователе (исполнителе или заказчике)
    public function getReviews(Request $request)
    {
        $user = $request->user();
        if($user->user_type_id === 1)
            $reviews = $user->aboutExecutorReviews;
        else if($user->user_type_id === 2)
            $reviews = $user->aboutCustomerReviews;
        else
            return $this->error('Unautorized', 403);

        return $this->success(ReviewResource::collection($reviews));
    }
    //Создание отзыва если задание выполнено или не выполнено
    public function createReview(CreateReviewRequest $request)
    {
        $user = $request->user();
        $data = $request->validated();
        $task = Task::find($data['task_id']);

        if($task->task_status_id == 5 || $task->task_status_id == 6){
            $review = Review::create(['comment' => $data['comment'], 'score_type_id' => $data['score_type_id'], 'task_id' => $data['task_id'], 'author_id' => $user->id, 'customer_id' => $data['customer_id'], 'executor_id' => $data['executor_id']]);
            return $this->success(new ReviewResource($review));
        }

        return $this->error('Invalid task status');
    }
}
