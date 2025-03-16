<?php
namespace Architecture\Infrastructure\Repository;

use Architecture\Application\Task\Dto\DtoInterface;

interface RepositoryInterface
{
    public function setCollectionName(string $collectionName): void;
    public function create(DtoInterface $dto): object;
    public function update(int $resourceId, DtoInterface $dto): bool;
    public function delete(int $resourceId): bool;
}