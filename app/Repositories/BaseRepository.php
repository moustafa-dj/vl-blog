<?php

namespace App\Repositories;

use App\Contracts\FilterContract;
use App\Traits\Findable;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements FilterContract {

    use Findable;

    public function __construct(Model $model , array $filters = [] , array $search=[])
    {
        $this->model = $model;
        $this->filters = $filters;
        $this->search = $search;
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
        $model = $model instanceof $this->model ? $model : $this->findById($model);

        $model->delete();
        
        return $model;
    }


}