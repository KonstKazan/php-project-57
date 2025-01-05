<?php

namespace Tests\Feature;

use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use JsonException;
use Tests\TestCase;

class TaskStatusTest extends TestCase
{
    use RefreshDatabase;

    public function testTaskStatusPage(): void
    {
        $response = $this->get('/task_statuses');

        $response->assertStatus(200);
    }

    /**
     * @throws JsonException
     */
    public function testTaskStatusCreate(): void
    {
        $response = $this
            ->post('/task_statuses', [
                'name' => 'Test Label',
            ]);
        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/task_statuses');

        $this->assertDatabaseHas('task_statuses', [
            'name' => 'Test Label',
        ]);
    }

    public function testTaskStatusSeed(): void
    {
        $this->seed();
        $this->assertDatabaseHas('task_statuses', [
            'name' => 'новый',
        ]);
    }

    /**
     * @throws JsonException
     */
    public function testTaskStatusUpdate(): void
    {
        $taskStatus = TaskStatus::factory()->create();
        $id = $taskStatus->id;
        $response = $this
            ->patch("/task_statuses/$id", [
                'name' => 'Test Status',
            ]);
        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/task_statuses');

        $this->assertDatabaseHas('task_statuses', [
            'name' => 'Test Status',
        ]);
    }

    /**
     * @throws JsonException
     */
    public function testTaskStatusDelete(): void
    {
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->get('/profile');

        $taskStatus = TaskStatus::factory()->create();
        $id = $taskStatus->id;
        $response = $this
            ->delete("/task_statuses/$id", ['status' => $taskStatus]);
        $response->assertSessionHasNoErrors();
        $this->assertModelMissing($taskStatus);
    }
}
