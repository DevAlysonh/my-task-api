<?php
namespace Architecture\Application\Common\Interfaces;

interface DtoInterface
{
    public static function fromArray(array $data): self;
    public function toArray(): array;
}