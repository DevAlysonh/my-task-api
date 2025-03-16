<?php
namespace Architecture\Application\Task;

enum TaskStatus: string
{
    case PENDING = 'pending';
    case PROGRESS = 'progress';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
}
