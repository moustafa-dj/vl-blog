<?php

namespace App\Repositories;

use App\Contracts\FilterContract;
use App\FindableTrait;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements FilterContract {

    use FindableTrait;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function create()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {
        
    }


}