<?php

namespace App\Enums;

use Illuminate\Support\Collection;

enum TaskStatus: string
{
    case Pending = 'pending';
    case InProgress = 'in_progress';
    case Completed = 'completed';

    public const PENDING = 'pending';
    public const INPROGRESS = 'in_progress';
    public const COMPLETED = 'completed';

    public static function statuses(): Collection
    {
        return collect([
            ["id" => self::Pending, "title" => __('Pending')],
            ["id" => self::InProgress, "title" => __('In Progress')],
            ["id" => self::Completed, "title" => __('Completed')],
        ]);
    }

    public static function getLabels(): ?array
    {
        return [
            self::PENDING => __('Pending'),
            self::INPROGRESS => __('In Progress'),
            self::COMPLETED => __('Completed'),
        ];
    }
}
