<?php

namespace Architecture\Domain\Comment\ValueObjects;

use InvalidArgumentException;

class Content
{
    protected string $value;

    public function __construct(protected string $content)
    {
        $this->validateContent($content);
        $this->value = $content;
    }

    public function value(): string
    {
        return $this->value;
    }

    private function validateContent(string $content)
    {
        if (empty(trim($content))) {
            throw new InvalidArgumentException("O conteúdo do comentário não pode estar vazio.");
        }

        if (strlen($content) > 500) {
            throw new InvalidArgumentException("O comentário não pode ter mais de 500 caracteres.");
        }
    }
}