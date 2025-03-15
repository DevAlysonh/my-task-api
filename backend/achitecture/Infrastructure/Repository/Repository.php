<?php

namespace Architecture\Infrastructure\Repository;

use Architecture\Application\Task\Dto\DtoInterface;

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