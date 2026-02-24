<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Task extends Model implements Sortable
{
    use SoftDeletes;
    use SortableTrait;

    protected $fillable = [
        'title',
        'description',
        'due_date',
        'status',
        'attachment',
        'user_id',
    ];
}
