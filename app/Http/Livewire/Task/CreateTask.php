<?php

namespace App\Http\Livewire\Task;

use App\Enums\RepetetionTypeEnum;
use App\Enums\TaskTypeEnum;
use App\Models\Task;
use App\Models\Repetetion;
use App\Models\TaskGroup;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CreateTask extends Component
{
    protected $rules;

    public $repetetionTypeList = [
        ['id' => 1, 'text' => 'Daily'],
        ['id' => 2, 'text' => 'Weekly'],
        ['id' => 3, 'text' => 'Monthly'],
        ['id' => 4, 'text' => 'Yearly']
    ];

    public $weekDaysList = [
        ['id' => 1, 'text' => 'Monday'],
        ['id' => 2, 'text' => 'Tuesday'],
        ['id' => 3, 'text' => 'Wednesday'],
        ['id' => 4, 'text' => 'Thursday'],
        ['id' => 5, 'text' => 'Friday'],
        ['id' => 6, 'text' => 'Saturday'],
        ['id' => 7, 'text' => 'Sunday'],
    ];

    public $monthsList = [];

    public $monthDaysList = [];

    public $groupsList = [];

    public $group =  null;
    public $title =  "";
    public $description = "";
    public $repetetionType;
    public $taskType;
    public $noOfIterations = 1;
    public $selectedDays = [];
    public $selectedMonth;
    public $selectedDate;
    public $startDate;
    public $endDate;

    public function mount()
    {
        $this->repetetionType = RepetetionTypeEnum::daily->value;
        $this->taskType = TaskTypeEnum::dates->value;
        
        for ($i = 1; $i <= 12; $i++) {
            $this->monthsList[] = ['id' => $i, 'text' => $i];
        }

        for ($i = 1; $i <= 30; $i++) {
            $this->monthDaysList[] = ['id' => $i, 'text' => $i];
        }

        $this->groupsList = TaskGroup::all()->toArray();
    }

    public function save()
    {
        $this->customValidate();

        $iterations = [];
        if ($this->repetetionType == RepetetionTypeEnum::weekly->value) {
            $iterations = $this->selectedDays;
        } elseif ($this->repetetionType == RepetetionTypeEnum::monthly->value) {
            $iterations = [$this->selectedDate];
        } elseif ($this->repetetionType == RepetetionTypeEnum::yearly->value) {
            $iterations = [$this->selectedDate, $this->selectedMonth];
        }

        $task = Task::create([
            'user_id' => Auth::user()->id,
            'task_group_id' => $this->group,
            'task_type' => $this->taskType,
            'completed' => false,
            'title' => $this->title,
            'description' => $this->description,
            'repetetion_type' => $this->repetetionType,
            'from_date' => \Carbon\Carbon::createFromFormat('d-m-Y', $this->startDate)->format('Y-m-d'),
            'to_date' => \Carbon\Carbon::createFromFormat('d-m-Y', $this->endDate)->format('Y-m-d'),
            'repetetions_count' => $this->noOfIterations,
        ]);

        if ($task->repetetion_type == RepetetionTypeEnum::yearly->value) {
            Repetetion::create([
                'task_id' => $task->id,
                'day' => $iterations[0],
                'month' => $iterations[1]
            ]);
        } else {
            foreach ($iterations as $iteration) {
                Repetetion::create([
                    'task_id' => $task->id,
                    'day' => $iteration
                ]);
            }
        }

        $this->resetForm();
    }

    private function customValidate()
    {
        $this->rules = [
            'group' => 'required',
            'title' => 'required',
            'description' => 'required',
            'repetetionType' => 'required',
        ];
        if ($this->taskType == TaskTypeEnum::dates->value) {
            $this->rules += [
                'startDate' => 'required|date_format:d-m-Y',
                'endDate' => 'required|date_format:d-m-Y'
            ];
        } else {
            $this->rules += [
                'noOfIterations' => 'required|integer|min:1',
            ];
        }

        $this->validate();
    }

    private function resetForm()
    {
        $this->group = null;
        $this->title = "";
        $this->description = "";
        $this->repetetionType = RepetetionTypeEnum::daily->value;
        $this->taskType = TaskTypeEnum::dates->value;
        $this->noOfIterations = 1;
        $this->selectedDays = [];
        $this->selectedMonth = null;
        $this->selectedDate = null;
        $this->startDate = null;
        $this->endDate = null;
    }

    public function render()
    {
        return view('livewire.task.create-task');
    }
}
