<?php

namespace App\Http\Controllers\Api\User;

use App\Contracts\ProfileContract;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct(
        private readonly ProfileContract $profile
    )
    {
        
    }

    public function me(string $username , Request $request)
    {
        $profile = $this->profile->findBy(
            [
                'username' => $username
            ]
        );

        return response()->json([
            'record' => ProfileResource::make($profile->load('user.posts')),
        ]);
    }
}
