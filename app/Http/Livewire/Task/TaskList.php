<?php

namespace App\Http\Livewire\Task;

use App\Enums\RepetetionTypeEnum;
use App\Enums\TaskTypeEnum;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TaskList extends Component
{
    public $tasks;

    public function mount()
    {
        Auth::loginUsingId(1);
    }

    public function markIncomplete($taskId)
    {
        Task::find($taskId)->update([
            'completed' => false
        ]);
    }

    public function markComplete($taskId)
    {
        Task::find($taskId)->update([
            'completed' => true
        ]);
    }

    public function render()
    {
        $today = Task::today()->toArray();
        $tomorrow = Task::tomorrow()->toArray();
        $nextWeek = Task::nextWeek()->toArray();
        $nearFuture = Task::nearFuture()->toArray();
        $future = Task::future()->toArray();

        $this->tasks = $today;
        return view('livewire.task.task-list');
    }
}
