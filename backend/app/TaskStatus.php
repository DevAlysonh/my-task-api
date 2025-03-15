<?php

namespace App;

enum TaskStatus: string
{
    case PENDING = 'pending';
    case PROGRESS = 'progress';
    case COMPLETE = 'completed';
    case CANCELLED = 'cancelled';
}
