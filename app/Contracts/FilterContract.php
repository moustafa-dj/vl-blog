<?php

namespace App\Contracts;

interface FilterContract{

    public function getAll();
    public function findById($id);
    public function findBy(array $params);
    public function withRelations(array $relations);
    public function findByFilter();
    public function findWithoutPagination();

}