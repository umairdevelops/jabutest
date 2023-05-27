<?php

namespace App\Http\Livewire\Group;

use App\Models\TaskGroup;
use Livewire\Component;

class GroupTable extends Component
{
    public $taskGroups;

    public function render()
    {
        $this->taskGroups = TaskGroup::all();
        return view('livewire.group.group-table');
    }
}
