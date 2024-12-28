<?php

namespace Tests\Feature;

use App\Models\Label;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LabelTest extends TestCase
{
    use RefreshDatabase;

    public function testLabelsPage(): void
    {
        $response = $this->get('/labels');

        $response->assertStatus(200);
    }

    /**
     * @throws \JsonException
     */
    public function testLabelCreate(): void
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

    public function testLabelSeed(): void
    {
        $this->seed();
        $this->assertDatabaseHas('labels', [
            'name' => 'ошибка',
        ]);
    }

    /**
     * @throws \JsonException
     */
    public function testLabelUpdate(): void
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
    public function testLabelDelete(): void
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
