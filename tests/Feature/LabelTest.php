<?php

namespace Tests\Feature;

use App\Models\Label;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LabelTest extends TestCase
{
    use RefreshDatabase;

    public function test_labels_page(): void
    {
        $response = $this->get('/labels');

        $response->assertStatus(200);
    }

    /**
     * @throws \JsonException
     */
    public function test_label_create(): void
    {
        $response = $this
            ->post('/labels', [
                'name' => 'Test Label',
                'description' => 'Test Description',
            ]);
        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/labels');

        $this->assertDatabaseHas('labels', [
            'description' => 'Test Description',
        ]);
    }

    public function test_label_seed(): void
    {
        $this->seed();
        $this->assertDatabaseHas('labels', [
            'name' => 'ошибка',
        ]);
    }

    /**
     * @throws \JsonException
     */
    public function test_label_update(): void
    {
        $this->seed();
        $id = Label::all()->first()->value('id');
        $response = $this
            ->patch("/labels/$id", [
                'name' => 'Test Label',
                'description' => 'Test Description',
            ]);
        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/labels');

        $this->assertDatabaseHas('labels', [
            'description' => 'Test Description',
        ]);
    }

    /**
     * @throws \JsonException
     */
    public function test_label_delete(): void
    {
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->get('/profile');

        $this->seed();
        $label = Label::all()->first();
        $id = $label->value('id');
        $response = $this
            ->delete("/labels/$id", ['label' => $label]);
        $response->assertSessionHasNoErrors();
        $this->assertModelMissing($label);
    }
}
