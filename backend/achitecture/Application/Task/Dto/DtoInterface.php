<?php

namespace Architecture\Application\Task\Dto;

interface DtoInterface
{
    public static function fromArray(array $data): self;
    public function toArray(): array;
}
