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
            'pass' => 'required|string|min:8|max:24'
        ]);

        $user = $this->user->findByAttribute(['email' => $data['email']]);

        if($user)
        {
            return response()->json(['There is not record matches the credentials'],403);
        }

        return response()->json([
            'user' => UserResource::make($user),
            'token' => $user->createToken()->plainTextToken
        ]);
    }
}
