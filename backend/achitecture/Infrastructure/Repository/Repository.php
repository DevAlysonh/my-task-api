<?php

namespace Architecture\Infrastructure\Repository;

use DtoInterface;
use Illuminate\Database\Eloquent\Model;
use RepositoryInterface;

class Repository implements RepositoryInterface
{
    public function __construct(
        protected RepositoryInterface $repository
    ) {
    }

    public function setCollectionName(string $collectionName): void
    {
        $this->repository->setCollectionName($collectionName);
    }

    public function create(DtoInterface $dto): object
    {
        return $this->repository->create($dto);
    }
}