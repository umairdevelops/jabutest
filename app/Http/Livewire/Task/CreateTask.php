<?php

namespace App\Http\Livewire\Task;

use Livewire\Component;

class CreateTask extends Component
{
    public $frequencies = [
        ['id' => 'daily', 'text' => 'Daily'],
        ['id' => 'weekly', 'text' => 'Weekly'],
        ['id' => 'monthly', 'text' => 'Monthly'],
        ['id' => 'yearly', 'text' => 'Yearly'],
    ];
    public $daysofMonth = [];
    public $iterationType = 'dateRange';

    public $task_groups;



    public $daysofweek = [
        ['id' => 'Monday', 'text' => 'Monday'],
        ['id' => 'Tuesday', 'text' => 'Tuesday'],
        ['id' => 'Wednesday', 'text' => 'Wednesday'],
        ['id' => 'Thursday', 'text' => 'Thursday'],
        ['id' => 'Friday', 'text' => 'Friday'],
        ['id' => 'Saturday', 'text' => 'Saturday'],
        ['id' => 'Sunday', 'text' => 'Sunday'],
    ];
    public $taskType = 'daily';

    public function mount()
    {

    }
    public function render()
    {
        return view('livewire.task.create-task');
    }
}
