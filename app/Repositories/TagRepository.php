<?php

namespace App\Repositories;

use App\Contracts\TagContract;
use App\Models\Tag;

class TagRepository extends BaseRepository implements TagContract
{
    public function __construct(Tag $model)
    {
        $this->model = $model;
    }

}