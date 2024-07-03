<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Publisher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class PublisherControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test the index method.
     *
     * @return void
     */
    public function test_index_displays_publishers()
    {
        $publishers = Publisher::factory()->count(10)->create();

        $response = $this->actingAs($this->createUser())->get(route('publishers'));

        $response->assertStatus(200);
        $response->assertViewIs('publisher.index');
        $response->assertViewHas('publishers');
    }

    /**
     * Test the create method.
     *
     * @return void
     */
    public function test_create_displays_create_form()
    {
        $response = $this->actingAs($this->createUser())->get(route('publisher.create'));

        $response->assertStatus(200);
        $response->assertViewIs('publisher.create');
    }

    /**
     * Test the store method.
     *
     * @return void
     */
    public function test_store_saves_new_publisher()
    {
        $data = [
            'name' => $this->faker->company,
        ];

        $response = $this->actingAs($this->createUser())->post(route('publisher.store'), $data);

        $response->assertRedirect(route('publishers'));
        $response->assertSessionHas('success', 'Publisher created successfully.');
        $this->assertDatabaseHas('publishers', $data);
    }

    /**
     * Test the edit method.
     *
     * @return void
     */
    public function test_edit_displays_edit_form()
    {
        $publisher = Publisher::factory()->create();

        $response = $this->actingAs($this->createUser())->get(route('publisher.edit', $publisher));

        $response->assertStatus(200);
        $response->assertViewIs('publisher.edit');
        $response->assertViewHas('publisher', $publisher);
    }

    /**
     * Test the update method.
     *
     * @return void
     */
    public function test_update_modifies_existing_publisher()
    {
        $publisher = Publisher::factory()->create();
        $data = [
            'name' => 'Updated Name',
        ];

        $response = $this->actingAs($this->createUser())->post(route('publisher.update', $publisher->id), $data);

        $response->assertRedirect(route('publishers'));
        $response->assertSessionHas('success', 'Publisher updated successfully.');
        $this->assertDatabaseHas('publishers', ['id' => $publisher->id, 'name' => 'Updated Name']);
    }

    /**
     * Test the destroy method.
     *
     * @return void
     */
    public function test_destroy_deletes_existing_publisher()
    {
        $publisher = Publisher::factory()->create();

        $response = $this->actingAs($this->createUser())->delete(route('publisher.destroy', $publisher->id));

        $response->assertRedirect(route('publishers'));
        $response->assertSessionHas('success', 'Publisher deleted successfully.');
        $this->assertDatabaseMissing('publishers', ['id' => $publisher->id]);
    }

    /**
     * Create a user for authentication.
     *
     * @return \App\Models\User
     */
    protected function createUser()
    {
        return User::factory()->create();
    }
}
