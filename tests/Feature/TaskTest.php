<?php

namespace Tests\Feature;

use App\Enums\RepetetionTypeEnum;
use App\Enums\TaskTypeEnum;
use App\Models\Task;
use App\Models\TaskGroup;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CreateTaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_task()
    {
        $user = User::factory()->create();
        
        $this->actingAs($user);

        $taskGroup = TaskGroup::factory()->create();

        $taskData = [
            'group' => $taskGroup->id,
            'title' => 'Test Task',
            'description' => 'Test Description',
            'repetetionType' => RepetetionTypeEnum::daily->value,
            'taskType' => TaskTypeEnum::dates->value,
            'noOfIterations' => 1,
            'selectedDays' => [],
            'selectedMonth' => null,
            'selectedDate' => null,
            'startDate' => '27-05-2023',
            'endDate' => '28-05-2023',
        ];

        Livewire::test(\App\Http\Livewire\Task\CreateTask::class)
            ->set('group', $taskData['group'])
            ->set('title', $taskData['title'])
            ->set('description', $taskData['description'])
            ->set('repetetionType', $taskData['repetetionType'])
            ->set('taskType', $taskData['taskType'])
            ->set('noOfIterations', $taskData['noOfIterations'])
            ->set('selectedDays', $taskData['selectedDays'])
            ->set('selectedMonth', $taskData['selectedMonth'])
            ->set('selectedDate', $taskData['selectedDate'])
            ->set('startDate', $taskData['startDate'])
            ->set('endDate', $taskData['endDate'])
            ->call('save');

        // Assertions
        $this->assertTrue(Task::where([
            'user_id' => $user->id,
            'task_group_id' => $taskData['group'],
            'task_type' => $taskData['taskType'],
            'completed' => false,
            'title' => $taskData['title'],
            'description' => $taskData['description'],
            'repetetion_type' => $taskData['repetetionType'],
            'from_date' => '2023-05-27',
            'to_date' => '2023-05-28',
            'repetetions_count' => $taskData['noOfIterations'],
        ])->exists());

        // Assert any other expectations regarding task creation or related data

    }
}
