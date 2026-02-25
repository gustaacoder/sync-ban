<?php

namespace App\Filament\Pages;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Models\Task;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
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

    protected function getEditModalFormSchema(int|string|null $recordId): array
    {
        return [
            TextInput::make('title')
                ->label(__('Task'))
                ->required(),
            Grid::make()
                ->columns(2)
                ->schema([
                    DatePicker::make('due_date')
                        ->label(__('Due Date'))
                        ->live()
                        ->prefixIcon('heroicon-o-calendar')
                        ->prefixIconColor(fn($get) => $get('due_date') ? 'secondary' : 'gray'),
                    Select::make('user_id')
                        ->label(__('Responsible'))
                        ->live()
                        ->prefixIcon('heroicon-o-user')
                        ->prefixIconColor(fn($get) => $get('user_id') ? 'secondary' : 'gray')
                        ->options(User::orderBy('name')->pluck('name', 'id')),
                    Select::make('status')
                        ->label(__('Status'))
                        ->live()
                        ->prefixIcon(function ($get) {
                            $status = $get('status');

                            switch ($status) {
                                case TaskStatus::PENDING:
                                    return 'heroicon-o-clock';
                                case TaskStatus::INPROGRESS:
                                    return 'heroicon-c-arrow-path';
                                case TaskStatus::COMPLETED:
                                    return 'heroicon-o-check-circle';
                                default:
                                    return 'heroicon-o-check-circle';
                            }
                        })
                        ->prefixIconColor(function ($get) {
                            $status = $get('status');

                            switch ($status) {
                                case TaskStatus::PENDING:
                                    return 'danger';
                                case TaskStatus::INPROGRESS:
                                    return 'warning';
                                case TaskStatus::COMPLETED:
                                    return 'success';
                                default:
                                    return 'gray';
                            }
                        })
                        ->options(TaskStatus::getLabels()),
                    Select::make('priority')
                        ->label(__('Priority'))
                        ->live()
                        ->options(TaskPriority::getLabels())
                        ->prefixIcon('heroicon-o-flag')
                        ->prefixIconColor(function ($get) {
                            $priority = $get('priority');
                            switch ($priority) {
                                case TaskPriority::LOW:
                                    return 'success';
                                case TaskPriority::MEDIUM:
                                    return 'warning';
                                case TaskPriority::HIGH:
                                    return 'danger';
                                default:
                                    return 'gray';
                            }
                        }),
                ]),
            RichEditor::make('description')
                ->label(__('Description'))
                ->fileAttachmentsDirectory('attachments')
                ->fileAttachmentsVisibility('public'),
        ];
    }

    protected function getEditModalTitle(): string
    {
        return __('Edit Task');
    }

    protected function getEditModalSaveButtonLabel(): string
    {
        return __('Save');
    }

    protected function getEditModalCancelButtonLabel(): string
    {
        return __('Cancel');
    }

    protected function getEditModalWidth(): string
    {
        return '4xl';
    }
}
