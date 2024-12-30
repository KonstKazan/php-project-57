<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function testTaskPage(): void
    {
        $response = $this->get('/tasks');

        $response->assertStatus(200);
    }

    /**
     * @throws \JsonException
     */
    public function testTaskCreate(): void
    {
//        $this->seed();
        $user = User::factory()->create();
        $userId = $user->id;

        $this
            ->actingAs($user)
            ->get('/profile');

//        $taskStatus = TaskStatus::all()->first();
//        $StatusId = $taskStatus->value('id');
        $taskStatus = TaskStatus::factory()->create();
        $statusId = $taskStatus->id;
        $task = Task::factory()->create([
            'status_id' => $taskStatus->id,
            'assigned_to_id' => $user->id,
            'created_by_id' => $user->id,
        ]);
        $response = $this
            ->post('/tasks', [
                'name' => 'Test Task',
                'description' => 'Test Description',
                'status_id' => $statusId,
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
    public function testTaskUpdate(): void
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
    public function testTaskDelete(): void
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
