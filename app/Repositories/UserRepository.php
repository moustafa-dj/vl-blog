<?php

namespace App\Repositories;

use App\Contracts\UserContract;
use App\Models\User;
use App\Services\FileUploadService;

class UserRepository extends BaseRepository implements UserContract
{
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function create(array $data)
    {        
        $profile = null;

        if(array_key_exists('profile',$data)){
            $profile = (new FileUploadService())->uploadAndGetPath($data['profile'],'/users/profile');
        }

        $user = $this->model::create([
            ...$data,
            'profile' => $profile ?? ''
        ]);

        return $user;
    }

}