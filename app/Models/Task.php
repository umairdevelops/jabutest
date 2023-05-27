<?php

namespace App\Models;

use App\Traits\TaskManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use TaskManager;
    
    protected $fillable = [
        'user_id',
        'task_group_id',
        'title',
        'description',
        'from_date',
        'to_date',
        'completed',
        'task_type',
        'repetetion_type',
        'repetetions_count'
    ];

    public function repetetions()
    {
        return $this->hasMany(Repetetion::class);
    }

    public function group() : BelongsTo
    {
        return $this->belongsTo(TaskGroup::class, 'task_group_id');
    }
}
