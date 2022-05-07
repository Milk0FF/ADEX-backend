<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\ChangeAvatarRequest;
use App\Http\Requests\Api\User\SetUserInfoRequest;
use App\Http\Resources\UserInfoResource;
use App\Models\Media;
use App\Models\UserInfo;
use App\Services\MediaService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $mediaService;

    public function __construct()
    {
        $this->mediaService = new MediaService();
    }

    /**
     *
     * @OA\Get(
     *     path="/user",
     *     operationId="getUserInfo",
     *     tags={"User"},
     *     summary="Получить личную информацию пользователя",
     *     security={
     *          {"bearer": {}}
     *     },
     *     @OA\Response(
     *        response=200,
     *        description="Successful operation",
     *        @OA\JsonContent(
     *           @OA\Property(property="id", type="int", example="1"),
     *           @OA\Property(property="firstname", type="string", example="Ivan"),
     *           @OA\Property(property="lastname", type="string", example="Ivan"),
     *           @OA\Property(property="about", type="string", example="Я пользователь биржы ADEX"),
     *           @OA\Property(property="phone", type="int", example="79549765434"),
     *           @OA\Property(property="city", type="string", example="Москва"),
     *           @OA\Property(property="country", type="string", example="Россия"),
     *           @OA\Property(property="rating", type="string", example="Россия"),
     *           @OA\Property(property="employment_type", type="string", example="Россия"),
     *           @OA\Property(property="avatar", type="string", example="https::/127.0.0.1/storage/123.png"),
     *           @OA\Property(property="success_reviews", type="string", example="5"),
     *           @OA\Property(property="failed_reviews", type="string", example="2"),
     *           @OA\Property(property="created_at", type="date", example="2021-04-04"),
     *        ),
     *      ),
     *     @OA\Response(
     *        response=401,
     *        description="Unauthenticated.",
     *        @OA\JsonContent(
     *          @OA\Property(property="message", type="string", example="Unauthenticated"),
     *        ),
     *      ),
     * )
     *
     * @return JsonResponse
     */

    //Получение личной информации пользователя
    public function getUserInfo(Request $request)
    {
        $user = $request->user();
        return $this->success(new UserInfoResource($user->userInfo));
    }

    /**
     *
     * @OA\Put(
     *     path="/user",
     *     operationId="updateUserInfo",
     *     tags={"User"},
     *     summary="Изменить личную информацию пользователя",
     *     security={
     *          {"bearer": {}}
     *     },
     *     @OA\RequestBody(
     *        required=true,
     *        description = "Заполните поля для изменения личной информации пользователя (employment_type: 1 - свободен, 2 - занят)",
     *        @OA\JsonContent(
     *           @OA\Property(property="firstname", type="string", example="Ivan"),
     *           @OA\Property(property="lastname", type="string", example="Ivan"),
     *           @OA\Property(property="about", type="string", example="Я пользователь биржы ADEX"),
     *           @OA\Property(property="phone", type="int", example="79549765434"),
     *           @OA\Property(property="city", type="string", example="Москва"),
     *           @OA\Property(property="country", type="string", example="Россия"),
     *           @OA\Property(property="birth_date", type="date", example="21-04-1980"),
     *           @OA\Property(property="employment_type", type="ште", example="2"),
     *       ),
     *     ),
     *     @OA\Response(
     *        response=204,
     *        description="Successful operation",
     *        @OA\JsonContent(),
     *      ),
     *     @OA\Response(
     *        response=401,
     *        description="Unauthenticated.",
     *        @OA\JsonContent(
     *          @OA\Property(property="message", type="string", example="Unauthenticated"),
     *        ),
     *      ),
     * )
     */

    //Изменение личной информации пользователя
    public function setUserInfo(SetUserInfoRequest $request)
    {
        $user = $request->user();
        $data = $request->all();
        if(isset($data['employment_type'])){
            $data['employment_type_id'] = $data['employment_type'];
            unset($data['employment_type']);
        }
        UserInfo::where('id', $user->id)->update($data);
        return $this->success('', 204);
    }

    /**
     *
     * @OA\Delete(
     *     path="/user",
     *     operationId="deleteUser",
     *     tags={"User"},
     *     summary="Удаление своей учётной записи",
     *     security={
     *          {"bearer": {}}
     *     },
     *     @OA\Response(
     *        response=204,
     *        description="Successful operation",
     *        @OA\JsonContent(),
     *      ),
     * )
     */

    //Удаление пользователя
    public function deleteUser(Request $request)
    {
        $user = $request->user();
        $userInfo = $user->userInfo;
        $user->delete();
        $userInfo->delete();
        $this->success('', 204);
    }

    /**
     *
     * @OA\Post(
     *     path="/user/avatar",
     *     operationId="changeAvatar",
     *     tags={"User"},
     *     summary="Изменить аватар",
     *     security={
     *          {"bearer": {}}
     *     },
     *     @OA\Response(
     *        response=200,
     *        description="Successful operation",
     *        @OA\JsonContent(
     *          @OA\Property(property="image", type="string", example="https::/127.0.0.1/storage/123.png"),
     *        ),
     *      ),
     *     @OA\Response(
     *        response=500,
     *        description="Failed change user avatar",
     *        @OA\JsonContent(
     *          @OA\Property(property="message", type="string", example="Failed change user avatar"),
     *        ),
     *      ),
     * )
     */

    //Изменение аватара пользователя
    public function changeAvatar(ChangeAvatarRequest $request)
    {
        $user = $request->user();
        $data = $request->all();
        $userInfo = $user->userInfo;
        $oldAvatar = $userInfo->avatar;

        if($oldAvatar)
            $this->mediaService->delete($oldAvatar->id);
        $newAvatar = $this->mediaService->addMedia($data['image'], 1);
        if(!$newAvatar)
            return $this->error('Failed change user avatar');
        $userInfo->media_id = $newAvatar->id;
        $userInfo->save();

        return $this->success(['image' => url($newAvatar->url)]);
    }

}
