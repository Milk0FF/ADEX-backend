<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RegisterRequest;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function doRegister(RegisterRequest $request)
    {
        $data = $request->all();
        $user = User::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'user_type_id' => $data['user_type']
        ]);
        $userInfo = UserInfo::create();
        $user->username = 'userreg' . $user->id;
        $user->user_info_id = $userInfo->id;
        $user->save();
        return $this->success(null, 201);
    }
}
