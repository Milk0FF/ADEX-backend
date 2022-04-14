<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RegisterRequest;
use App\Models\User;
use App\Models\UserInfo;

class RegisterController extends Controller
{
    public function doRegister(RegisterRequest $request)
    {
        $data = $request->all();
        $user = User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);
        $userInfo = UserInfo::create();
        $user->user_info_id = $userInfo->id;
        $user->save();
        return $this->success(null, 201);
    }
}
