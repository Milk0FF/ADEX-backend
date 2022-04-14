<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function doLogin(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        if(!Auth::attempt($credentials))
            return $this->error('Login or password incorrect', 401);

        $user = User::where('email', $credentials['email'])->first();
        $token = $user->createToken('auth')->plainTextToken;
        return $this->success([
            'token' => $token,
        ]);
    }
    public function logout(Request $request){
        $authUser = $request->user();
        $authUser->tokens()->delete();
        return $this->success([], 204);
    }
}
