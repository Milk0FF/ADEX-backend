<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserInfoResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUserInfo(Request $request)
    {
        $user = $request->user();
        return $this->success(new UserInfoResource($user->userInfo));
    }
}
