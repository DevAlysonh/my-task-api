<?php

namespace Architecture\Application\Task\Dto;

use App\Models\User;
use Architecture\Application\Common\Interfaces\DtoInterface;
use Architecture\Domain\Task\ValueObjects\Description;
use Architecture\Domain\Task\ValueObjects\Title;

class TaskInputDto implements DtoInterface
{
    public function __construct(
        protected Title $title,
        protected Description $description,
        protected User $user
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            new Title($data['title']),
            new Description($data['description']),
            auth()->user()
        );
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title->value(),
            'description' => $this->description->value(),
            'user_id' => $this->user->id 
        ];
    }
}