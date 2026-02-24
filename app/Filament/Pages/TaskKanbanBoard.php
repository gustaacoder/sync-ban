<?php

namespace App\Filament\Pages;

use App\Enums\TaskStatus;
use App\Models\Task;
use Illuminate\Support\Collection;
use Mokhosh\FilamentKanban\Pages\KanbanBoard;

class TaskKanbanBoard extends KanbanBoard
{
    protected static string $model = Task::class;
    protected static string $statusEnum = TaskStatus::class;
    protected static string $recordTitleAttribute = 'title';

    protected function statuses(): Collection
    {
        return TaskStatus::statuses();
    }

    protected function records(): Collection
    {
        return Task::ordered()->get();
    }

    public function onStatusChanged(int|string $recordId, string $status, array $fromOrderedIds, array $toOrderedIds): void
    {
        Task::find($recordId)->update(['status' => $status]);
        Task::setNewOrder($toOrderedIds);
    }

    public function onSortChanged(int|string $recordId, string $status, array $orderedIds): void
    {
        Task::setNewOrder($orderedIds);
    }
}
