<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //Авторизация пользователя
    public function doLogin(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        if(!Auth::attempt($credentials))
            return $this->error('Login or password incorrect', 401);

        $user = User::where('email', $credentials['email'])->first();
        $token = $user->createToken('auth')->plainTextToken;
        return $this->success([
            'token' => $token,
            'user_type' => $user->user_type_id,
        ]);
    }
    //Выход из системы пользователя
    public function logout(Request $request){
        $authUser = $request->user();
        $authUser->tokens()->delete();
        return $this->success('', 204);
    }
}
