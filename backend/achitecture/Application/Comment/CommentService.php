<?php

namespace Architecture\Application\Comment;

use App\Models\Comment;
use Architecture\Application\Comment\Dto\CommentInputDto;
use Architecture\Infrastructure\Repository\Repository;

class CommentService
{
    public function __construct(
        protected Repository $repository
    ) {
        $this->repository->setCollectionName('comment');
    }

    public function create(CommentInputDto $comment): Comment
    {
        return $this->repository->create($comment);
    }

    public function delete(Comment $comment)
    {
        return $this->repository->delete((int)$comment->id);
    }
}