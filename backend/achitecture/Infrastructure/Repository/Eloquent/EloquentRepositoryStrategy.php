<?php

namespace Architecture\Infrastructure\Repository\Eloquent;

use DtoInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;
use RepositoryInterface;

class EloquentRepositoryStrategy implements RepositoryInterface
{
    protected Model $model;

    public function setCollectionName(string $collectionName): void
    {
        $modelString = "App\\Models\\" . ucfirst($collectionName);

        if(!class_exists($modelString)) {
            throw new Exception("Class {$modelString} does not exists");
        }

        $this->model = new $modelString();
    }

    public function create(DtoInterface $dto): Model
    {
        return $this->model::create($dto->toArray());
    }
}