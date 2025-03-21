<?php

namespace Architecture\Infrastructure\Repository\Eloquent;

use Architecture\Application\Common\Interfaces\DtoInterface;
use Architecture\Infrastructure\Repository\RepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

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

    public function update(int $resourceId, DtoInterface $dto): bool
    {
        return $this->model::where('id', $resourceId)->update($dto->toArray());
    }

    public function delete(int $resourceId): bool
    {
        return $this->model::where('id', $resourceId)->delete();
    }

    public function findBySubquery(?int $perPage = null, callable $subquery): Collection|LengthAwarePaginator
    {
        return $perPage
            ? $subquery($this->model)->paginate($perPage)
            : $subquery($this->model)->get();
    }
}