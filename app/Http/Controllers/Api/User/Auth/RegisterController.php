<?php

namespace App\Http\Controllers\Api\User\Auth;

use App\Contracts\UserContract;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function __construct(protected readonly UserContract $user)
    {
        
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:256',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|max:24|confirmed',
            'profile' => 'nullable|file|mimes:png,jpg,jpeg'
        ]);

        $user = $this->user->create($data);

        $access_token = $user->createToken($user->id)->plainTextToken;

        return response()->json([
            'user' => UserResource::make($user),
            'access_token' => $access_token
        ]);
    }
}
