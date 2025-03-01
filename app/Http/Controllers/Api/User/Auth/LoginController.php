<?php

namespace App\Http\Controllers\Api\User\Auth;

use App\Contracts\UserContract;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function __construct(protected readonly UserContract $user)
    {
        
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8|max:24'
        ]);

        $user = $this->user->findBy(['email' => $data['email']]);

        if(!$user)
        {
            return response()->json(['There is no record matches the credentials'],403);
        }

        return response()->json([
            'user' => UserResource::make($user),
            'token' => $user->createToken($user->id)->plainTextToken
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['success'],201);
    }
}
