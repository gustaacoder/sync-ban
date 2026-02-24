<?php

namespace App\Enums;

use Illuminate\Support\Collection;

enum TaskStatus: string
{
    case Pending = 'pending';
    case InProgress = 'in_progress';
    case Completed = 'completed';

    public static function statuses(): Collection
    {
        return collect([
            ["id" => self::Pending, "title" => __('Pending')],
            ["id" => self::InProgress, "title" => __('In Progress')],
            ["id" => self::Completed, "title" => __('Completed')],
        ]);
    }
}
