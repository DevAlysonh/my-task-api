<?php

namespace Architecture\Infrastructure\Repository\Eloquent;

use Architecture\Application\Task\Dto\DtoInterface;
use Architecture\Infrastructure\Repository\RepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;

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

    public function update(object $original, DtoInterface $dto): bool
    {
        if(! $original instanceof Model) {
            throw new Exception("You shoud give an instance of laravel's Model to update");
        }

        return $original->update($dto->toArray());
    }
}