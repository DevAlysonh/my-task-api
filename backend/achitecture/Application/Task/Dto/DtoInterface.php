<?php

interface DtoInterface
{
    public static function fromArray(array $data): self;
    public function toArray(): array;
}
