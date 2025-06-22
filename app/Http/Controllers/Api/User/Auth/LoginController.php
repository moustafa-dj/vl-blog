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

        try{
            $user = $this->user->findBy(['email' => $data['email']]);
            return response()->json([
                'user' => UserResource::make($user),
                'token' => $user->createToken($user->id)->plainTextToken
            ]);

        }catch(\Exception $e){
            return response()->json([$e->getMessage()],403);
        }

    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['success'],201);
    }
}
