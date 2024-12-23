<?php

namespace Tests\Feature;

use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskStatusTest extends TestCase
{
    use RefreshDatabase;

    public function test_task_status_page(): void
    {
        $response = $this->get('/task_statuses');

        $response->assertStatus(200);
    }

    /**
     * @throws \JsonException
     */
    public function test_task_status_create(): void
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

    public function test_task_status_seed(): void
    {
        $this->seed();
        $this->assertDatabaseHas('task_statuses', [
            'name' => 'новый',
        ]);
    }

    /**
     * @throws \JsonException
     */
    public function test_task_status_update(): void
    {
        $this->seed();
        $id = TaskStatus::all()->first()->value('id');
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
     * @throws \JsonException
     */
    public function test_task_status_delete(): void
    {
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->get('/profile');
        $this->seed();
        $status = TaskStatus::all()->first();
        $id = $status->value('id');
        $response = $this
            ->delete("/task_statuses/$id", ['status' => $status]);
        $response->assertSessionHasNoErrors();
        $this->assertModelMissing($status);
    }
}
