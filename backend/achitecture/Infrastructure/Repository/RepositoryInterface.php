<?php

interface RepositoryInterface
{
    public function setCollectionName(string $collectionName): void;
    public function create(DtoInterface $dto): object;
}