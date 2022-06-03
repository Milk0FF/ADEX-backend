<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Review\CreateReviewRequest;
use App\Http\Requests\Api\Review\GetUserReviewsRequest;
use App\Http\Resources\ReviewResource;
use App\Http\Resources\StatusResource;
use App\Models\Chat;
use App\Models\Review;
use App\Models\ScoreType;
use App\Models\Task;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     *
     * @OA\Get(
     *     path="/reviews",
     *     operationId="getReviews",
     *     tags={"Reviews"},
     *     summary="Получение отзывов о пользователе",
     *     security={
     *          {"bearer": {}}
     *     },
     *     @OA\Response(
     *        response=200,
     *        description="Successful operation",
     *        @OA\JsonContent(
     *           @OA\Property(property="id", type="int", example="1"),
     *           @OA\Property(property="comment", type="string", example="Это лучший заказчик с которым я работал!"),
     *           @OA\Property(property="score", type="string", example="Положительно"),
     *
     *           @OA\Property(property="task", type="object",
     *             @OA\Property(property="id", type="int", example="1"),
     *             @OA\Property(property="name", type="string", example="Создать рекламу"),
     *             @OA\Property(property="description", type="string", example="Создать рекламу на тему пиар"),
     *             @OA\Property(property="price", type="int", example="1200"),
     *             @OA\Property(property="views", type="int", example="15"),
     *             @OA\Property(property="status", type="string", example="Busy"),
     *             @OA\Property(property="categories", type="object",
     *               @OA\Property(property="id", type="int", example="1"),
     *               @OA\Property(property="name", type="string", example="Video"),
     *             ),
     *             @OA\Property(property="created_at", type="date", example="2021-04-04"),
     *          ),
     *           @OA\Property(property="author", type="object",
     *             @OA\Property(property="id", type="int", example="1"),
     *             @OA\Property(property="username", type="string", example="userreg1"),
     *             @OA\Property(property="firstname", type="string", example="Ivan"),
     *             @OA\Property(property="lastname", type="string", example="Ivanovich"),
     *          ),
     *
     *           @OA\Property(property="customer", type="object",
     *             @OA\Property(property="id", type="int", example="1"),
     *             @OA\Property(property="username", type="string", example="userreg1"),
     *             @OA\Property(property="firstname", type="string", example="Ivan"),
     *             @OA\Property(property="lastname", type="string", example="Ivanovich"),
     *          ),
     *          @OA\Property(property="executor", type="object",
     *             @OA\Property(property="id", type="int", example="1"),
     *             @OA\Property(property="username", type="string", example="userreg1"),
     *             @OA\Property(property="firstname", type="string", example="Ivan"),
     *             @OA\Property(property="lastname", type="string", example="Ivanovich"),
     *          ),
     *          @OA\Property(property="created_at", type="date", example="2021-04-04"),
     *        ),
     *      ),
     *     @OA\Response(
     *        response=401,
     *        description="Unauthenticated.",
     *        @OA\JsonContent(
     *          @OA\Property(property="message", type="string", example="Unauthenticated"),
     *        ),
     *      ),
     *     @OA\Response(
     *        response=403,
     *        description="Unautorized.",
     *        @OA\JsonContent(
     *           @OA\Property(property="errors", type="object",
     *              @OA\Property(property="message", type="string", example="Unautorized"),
     *           ),
     *        ),
     *      ),
     * )
     *
     * @return JsonResponse
     */

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


    public function getUserReviews(GetUserReviewsRequest $request)
    {
        $data = $request->validated();
        if($data['user_type'] == 1)
            $reviews = Review::where('executor_id', '=', $data['user_id'])->where('author_id', '!=', $data['user_id'])->get();
        else if($data['user_type'] == 2)
            $reviews = Review::where('customer_id', '=', $data['user_id'])->where('author_id', '!=', $data['user_id'])->get();

        return $this->success(ReviewResource::collection($reviews));
    }
    /**
     *
     * @OA\Post(
     *     path="/review",
     *     operationId="createReview",
     *     tags={"Reviews"},
     *     summary="Создать отзыв",
     *     security={
     *          {"bearer": {}}
     *     },
     *     @OA\RequestBody(
     *        required=true,
     *        description = "Заполните поля для создания отзыва",
     *        @OA\JsonContent(
     *           required={"comment", "score_type_id", "task_id", "customer_id", "executor_id"},
     *           @OA\Property(property="comment", type="int", example="Это лучший исполнитель с которым я работал"),
     *           @OA\Property(property="score_type_id", type="int", example="2"),
     *           @OA\Property(property="task_id", type="string", example="3"),
     *           @OA\Property(property="customer_id", type="int", example="1"),
     *           @OA\Property(property="executor_id", type="int", example="2"),
     *       ),
     *     ),
     *     @OA\Response(
     *        response=200,
     *        description="Successful operation",
     *        @OA\JsonContent(
     *           @OA\Property(property="id", type="int", example="1"),
     *           @OA\Property(property="comment", type="string", example="Это лучший заказчик с которым я работал!"),
     *           @OA\Property(property="score", type="string", example="Положительно"),
     *
     *           @OA\Property(property="task", type="object",
     *             @OA\Property(property="id", type="int", example="1"),
     *             @OA\Property(property="name", type="string", example="Создать рекламу"),
     *             @OA\Property(property="description", type="string", example="Создать рекламу на тему пиар"),
     *             @OA\Property(property="price", type="int", example="1200"),
     *             @OA\Property(property="views", type="int", example="15"),
     *             @OA\Property(property="status", type="string", example="Busy"),
     *             @OA\Property(property="categories", type="object",
     *               @OA\Property(property="id", type="int", example="1"),
     *               @OA\Property(property="name", type="string", example="Video"),
     *             ),
     *             @OA\Property(property="created_at", type="date", example="2021-04-04"),
     *          ),
     *           @OA\Property(property="author", type="object",
     *             @OA\Property(property="id", type="int", example="1"),
     *             @OA\Property(property="username", type="string", example="userreg1"),
     *             @OA\Property(property="firstname", type="string", example="Ivan"),
     *             @OA\Property(property="lastname", type="string", example="Ivanovich"),
     *          ),
     *
     *           @OA\Property(property="customer", type="object",
     *             @OA\Property(property="id", type="int", example="1"),
     *             @OA\Property(property="username", type="string", example="userreg1"),
     *             @OA\Property(property="firstname", type="string", example="Ivan"),
     *             @OA\Property(property="lastname", type="string", example="Ivanovich"),
     *          ),
     *          @OA\Property(property="executor", type="object",
     *             @OA\Property(property="id", type="int", example="1"),
     *             @OA\Property(property="username", type="string", example="userreg1"),
     *             @OA\Property(property="firstname", type="string", example="Ivan"),
     *             @OA\Property(property="lastname", type="string", example="Ivanovich"),
     *          ),
     *          @OA\Property(property="created_at", type="date", example="2021-04-04"),
     *        ),
     *      ),
     *     @OA\Response(
     *        response=401,
     *        description="Unauthenticated.",
     *        @OA\JsonContent(
     *          @OA\Property(property="message", type="string", example="Unauthenticated"),
     *        ),
     *      ),
     *     @OA\Response(
     *        response=500,
     *        description="Invalid task status",
     *        @OA\JsonContent(
     *           @OA\Property(property="errors", type="object",
     *              @OA\Property(property="message", type="string", example="Invalid task status"),
     *           ),
     *        ),
     *      ),
     * )
     *
     * @return JsonResponse
     */
    //Создание отзыва если задание выполнено или не выполнено
    public function createReview(CreateReviewRequest $request)
    {
        $user = $request->user();
        $data = $request->validated();

        $task = Task::find($data['task_id']);

        if($task->task_status_id == 5 || $task->task_status_id == 6){
            $review = Review::create(['comment' => $data['comment'], 'score_type_id' => $data['score_type_id'], 'task_id' => $data['task_id'], 'author_id' => $user->id, 'customer_id' => $data['customer_id'], 'executor_id' => $data['executor_id']]);
            $chat = Chat::where('executor_id', $data['executor_id'])->where('customer_id', $data['customer_id'])->where('task_id', $task->id)->first();
            $currentUserId = 0;

            if($user->id == $task->customer_id)
                $currentUserId = $task->executor_id;
            else if($user->id == $task->executor_id)
                $currentUserId = $task->customer_id;

            $currentUser = UserInfo::find($currentUserId);

            if($data['score_type_id'] == 1){
                $currentUser->rating += 1;
            } else if($data['score_type_id'] == 2) {
                if($currentUser->rating != 0)
                    $currentUser->rating -= 1;
            }
            $currentUser->save();

            if($user->id == $task->executor_id)
                $chat->isExecutorReviewAdded = true;
            if($user->id == $task->customer_id)
                $chat->isCustomerReviewAdded = true;

            $chat->save();

            return $this->success(new ReviewResource($review));
        }

        return $this->error('Invalid task status');
    }

    public function getScoreTypes(){
        $scoreTypes = ScoreType::all();
        return $this->success(StatusResource::collection($scoreTypes));
    }
}
