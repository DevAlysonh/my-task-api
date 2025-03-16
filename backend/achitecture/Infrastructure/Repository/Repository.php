<?php

namespace Architecture\Infrastructure\Repository;

use Architecture\Application\Common\Interfaces\DtoInterface;

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

    public function update(int $resourceId, DtoInterface $dto): bool
    {
        return $this->repository->update($resourceId, $dto);
    }

    public function delete(int $resourceId): bool
    {
        return $this->repository->delete($resourceId);
    }

    public function findBySubquery(?int $perPage = null, callable $subquery): object
    {
        return $this->repository->findBySubquery($perPage, $subquery);
    }
}