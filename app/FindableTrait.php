<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\Builder;

trait FindableTrait
{
    protected Model $model;
    public array $relations = [];
    protected array $scopes = [];
    protected int $perPage = 10; // Default number of items per page

    public function findByAttribute(array $attrs)
    {
        $query = $this->model->newQuery();
        
        foreach ($attrs as $attr => $value) {
            $query->where($attr, $value);
        }

        return $query->get();
    }

    public function setScope(string $scope, $value = null)
    {
        $this->scopes[$scope] = $value;
        return $this;
    }

    public function findById($id)
    {
        $query = $this->model::query()
            ->with($this->relations)
            ->where('id', $id);

        $this->applyScopes($query);

        return $query->firstOrFail();
    }

    public function getAll()
    {
        $query = $this->model::query()
            ->with($this->relations);
            
        $this->applyScopes($query);

        return $query->paginate($this->perPage); // Use paginate instead of get
    }

    public function setPerPage(int $perPage)
    {
        $this->perPage = $perPage;
        return $this;
    }

    protected function applyScopes(Builder $query)
    {
        foreach ($this->scopes as $scope => $value) {
            if (method_exists($this->model, 'scope'.ucfirst($scope))) {
                $query->{$scope}($value);
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
            ->where($params);

        $this->applyScopes($query);

        return $query->firstOrFail();
    }
}