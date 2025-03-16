<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\CreateComment;
use Architecture\Application\Comment\CommentService;
use Architecture\Application\Comment\Dto\CommentInputDto;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    public function __construct(
        protected CommentService $service
    ) {
    }

    public function store(CreateComment $request)
    {
        $comment = CommentInputDto::fromArray($request->validated());
        $created = $this->service->create($comment);

        return response()->json($created->refresh(), Response::HTTP_CREATED);
    }
}
