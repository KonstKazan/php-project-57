<?php

namespace Tests\Feature;

use App\Models\Label;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_task_page(): void
    {
        $response = $this->get('/tasks');

        $response->assertStatus(200);
    }

    /**
     * @throws \JsonException
     */
    public function test_task_create(): void
    {
        $this->seed();
        $user = User::factory()->create();
        $userId = $user->value('id');

        $this
            ->actingAs($user)
            ->get('/profile');

        $taskStatus = TaskStatus::all()->first();
        $StatusId = $taskStatus->value('id');
        $response = $this
            ->post('/tasks', [
                'name' => 'Test Task',
                'description' => 'Test Description',
                'status_id' => $StatusId,
                'assigned_to_id' => $userId,
                'labels' => [1, 2],
            ]);
        $response
            ->assertSessionHasNoErrors()->assertRedirect('/tasks');

        $this->assertDatabaseHas('tasks', [
            'name' => "Test Task",
        ]);
    }


    /**
     * @throws \JsonException
     */
    public function test_task_update(): void
    {
        $user = User::factory()->create();

        $status = TaskStatus::factory()->create();
        $task = Task::factory()->create([
            'status_id' => $status->id,
            'assigned_to_id' => $user->id,
            'created_by_id' => $user->id,
        ]);

        $response = $this
            ->patch("/tasks/$task->id", [
                'name' => 'Test Task',
                'description' => 'Test Description',
                'status_id' => $status->id,
                'assigned_to_id' => $user->id,
            ]);
        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/tasks');

        $this->assertDatabaseHas('tasks', [
            'description' => 'Test Description',
        ]);
    }

    /**
     * @throws \JsonException
     */
    public function test_task_delete(): void
    {
        $user = User::factory()->create();
        $this
            ->actingAs($user)
            ->get('/profile');

        $status = TaskStatus::factory()->create();
        $task = Task::factory()->create([
            'status_id' => $status->id,
            'assigned_to_id' => $user->id,
            'created_by_id' => $user->id,
        ]);

        $response = $this
            ->delete("/tasks/$task->id", ['task' => $task]);
        $response->assertSessionHasNoErrors();
        $this->assertModelMissing($task);
    }
}
