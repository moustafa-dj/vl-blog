<?php

namespace App\Repositories;

use App\Contracts\UserContract;
use App\Models\User;

class UserRepository extends BaseRepository implements UserContract
{
    public function __construct(User $model)
    {
        $this->model = $model;
    }

}