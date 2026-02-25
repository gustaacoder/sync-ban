<?php

namespace App\Enums;

enum TaskPriority
{
    public const LOW = 'low';
    public const MEDIUM = 'medium';
    public const HIGH = 'high';

    public static function getLabels(): ?array
    {
        return [
            self::LOW => __('Low'),
            self::MEDIUM => __('Medium'),
            self::HIGH => __('High'),
        ];
    }
}
