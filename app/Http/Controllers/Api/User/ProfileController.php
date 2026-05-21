<?php

namespace App\Http\Controllers\Api\User;

use App\Contracts\ProfileContract;
use App\Contracts\UserContract;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct(
        private readonly UserContract $user
    )
    {
        
    }

    public function me(string $username , Request $request)
    {
        $profile = $this->user->withRelations(['profileInfo','posts.comments'])->findBy(
            [
                'username' => $username
            ]
        );

        return response()->json([
            'record' => UserResource::make($profile),
        ]);
    }
}
