<?php

namespace Tests\Feature;

use App\Http\Livewire\CreateTask;
use App\Http\Livewire\GroupTable;
use App\Http\Livewire\TaskGroup;
use App\Http\Livewire\TaskList;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class PageLoadTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        $this->actingAs($user);
    }


    public function test_group_table_page_loads()
    {
        $this->withoutExceptionHandling();

        $response = $this->get(route('groups'));

        $response->assertStatus(200);
    }

    public function test_create_task_page_loads()
    {
        $this->withoutExceptionHandling();

        $response = $this->get(route('createTask'));

        $response->assertStatus(200);
    }

    public function test_task_list_page_loads()
    {
        $this->withoutExceptionHandling();

        $response = $this->get(route('tasks'));

        $response->assertStatus(200);
    }
}
