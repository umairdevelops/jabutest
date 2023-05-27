<?php

namespace App\Http\Livewire\Task;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TaskList extends Component
{
    public $activeTab = 'today';
    public $todayTasks = [];
    public $tomorrowTasks = [];
    public $nextWeekTasks = [];
    public $nearFutureTasks = [];
    public $futureTasks = [];

    public function mount()
    {
        $this->todayTasks = Task::today()->toArray();
        $this->tomorrowTasks = Task::tomorrow()->toArray();
        $this->nextWeekTasks = Task::nextWeek()->toArray();
        $this->nearFutureTasks = Task::nearFuture()->toArray();
        $this->futureTasks = Task::future()->toArray();
    }

    public function markIncomplete($taskId)
    {
        Task::find($taskId)->update([
            'completed' => false
        ]);
        $this->mount();
    }

    public function markComplete($taskId)
    {
        Task::find($taskId)->update([
            'completed' => true
        ]);
        $this->mount();
    }

    public function render()
    {
        $tasks = [];

        if ($this->activeTab === 'today') {
            $tasks = $this->todayTasks;
        } elseif ($this->activeTab === 'tomorrow') {
            $tasks = $this->tomorrowTasks;
        } elseif ($this->activeTab === 'nextWeek') {
            $tasks = $this->nextWeekTasks;
        } elseif ($this->activeTab === 'nearFuture') {
            $tasks = $this->nearFutureTasks;
        } elseif ($this->activeTab === 'future') {
            $tasks = $this->futureTasks;
        }
    
        return view('livewire.task.task-list', [
            'tasks' => $tasks,
        ]);
    }
}
