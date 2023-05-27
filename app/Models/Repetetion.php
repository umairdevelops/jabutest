<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repetetion extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'day',
        'month'
    ];
}
