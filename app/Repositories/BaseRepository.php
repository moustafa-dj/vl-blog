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

    public function create(array $data)
    {
        return $this->model::create($data);
    }

    public function update($model , $data)
    {
        $model = $model instanceof $this->model ? $model : $this->findById($model);

        $model->update($data);

        return $model;
    }

    public function destroy($model)
    {
        
    }


}