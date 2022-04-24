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
    //Получение личной информации пользователя
    public function getUserInfo(Request $request)
    {
        $user = $request->user();
        return $this->success(new UserInfoResource($user->userInfo));
    }
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
        return $this->success($data);
    }
    //Удаление пользователя
    public function deleteUser(Request $request)
    {
        $user = $request->user();
        $userInfo = $user->userInfo;
        $user->delete();
        $userInfo->delete();
    }
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
