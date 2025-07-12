<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

trait Findable
{
    protected Model $model;
    public array $relations = [];
    protected array $scopes = [];
    protected int $perPage = 10; // Default number of items per page
    protected array $filters = [];
    protected array $search = [];

    public function findById($id)
    {
        $query = $this->model::query()
            ->with($this->relations)
            ->where('id', $id)
            ->scopes($this->scopes);

        return $query->firstOrFail();
    }

    public function getAll()
    {
        $query = $this->model::query()
            ->with($this->relations)
            ->scopes($this->scopes);

        $this->applyFilters($query);
        return $query->paginate($this->perPage); // Use paginate instead of get
    }

    public function findByFilter()
    {
        $query = $this->model::query()
        ->with($this->relations)
        ->scopes($this->scopes);

        if(request()->has('search') && request()->filled('search'))
        {
            $query->whereAny($this->search , 'LIKE', '%'.request('search').'%');
        }

        if(request()->has('per_page')&& request()->filled('search'))
        {
            $this->setPerPage(request('per_page'));
        }
        $this->applyFilters($query);
        
        return $query?->paginate($this->perPage);
    }

    public function setPerPage(string $perPage)
    {
        $this->perPage = $perPage;
        return $this;
    }

    public function setScopes($scopes)
    {
        $this->scopes = $scopes;
        return $this;
    }

    public function getPerPage()
    {
        return $this->perPage;
    }

    protected function applyFilters(Builder $builder)
    {
        foreach($this->filters as $filter)
        {
            if(request()->has($filter) && request()->filled($filter))
            {
                $builder->where($filter , request($filter));
            }
        }
    }

    public function withRelations(array $relations)
    {
        $this->relations = $relations;
        return $this;
    }

    public function findBy(array $params)
    {
        $query = $this->model::query()
            ->with($this->relations)
            ->where($params)
            ->scopes($this->scopes);

        return $query->firstOrFail();
    }
    
}