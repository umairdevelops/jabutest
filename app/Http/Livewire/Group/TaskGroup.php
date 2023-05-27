<?php

namespace App\Http\Livewire\Group;

use App\Models\TaskGroup as ModelsTaskGroup;
use Livewire\Component;

class TaskGroup extends Component
{
    /**********************
     * Public Wire Models *
     **********************/
    public $group = [
        'name' => null,
        'description' => null
    ];

    /**************
     * Wire Events *
     ***************/
    public function save()
    {
        $this->validateForm();
        $this->storeTaskGroup();
        $this->clearForm();
        session()->flash('success', 'Task group saved successfully.');
    }

    public function cancel()
    {
        $this->clearForm();
    }

    public function render()
    {
        return view('livewire.group.task-group');
    }

    /****************
     * Core Methods *
     ***************/
    private function validateForm()
    {
        $this->validate([
            'group.name' => 'required',
        ]);
    }

    private function storeTaskGroup()
    {
        ModelsTaskGroup::create([
            'name' => $this->group['name'],
            'description' => $this->group['description'],
        ]);
    }

    private function clearForm()
    {
        $this->group = [
            'name' => null,
            'description' => null
        ];
    }
}
