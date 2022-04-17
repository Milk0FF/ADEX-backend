<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUserInfo(Request $request)
    {
        $user = $request->user();
        $user->userInfo();
    }
}
