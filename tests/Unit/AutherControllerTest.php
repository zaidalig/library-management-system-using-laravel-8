<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Auther;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class AutherControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test the index method.
     *
     * @return void
     */
    public function test_index_displays_authors()
    {
        $authors = Auther::factory()->count(10)->create();

        $response = $this->actingAs($this->createUser())->get(route('authors'));

        $response->assertStatus(200);
        $response->assertViewIs('auther.index');
        $response->assertViewHas('authors');
    }

    /**
     * Test the create method.
     *
     * @return void
     */
    public function test_create_displays_create_form()
    {
        $response = $this->actingAs($this->createUser())->get(route('authors.create'));

        $response->assertStatus(200);
        $response->assertViewIs('auther.create');
    }

    /**
     * Test the store method.
     *
     * @return void
     */
    public function test_store_saves_new_author()
    {
        $data = [
            'name' => $this->faker->name,
        ];

        $response = $this->actingAs($this->createUser())->post(route('authors.store'), $data);

        $response->assertRedirect(route('authors'));
        $response->assertSessionHas('success', 'Author created successfully.');
        $this->assertDatabaseHas('authers', $data);
    }

    /**
     * Test the edit method.
     *
     * @return void
     */
    public function test_edit_displays_edit_form()
    {
        $author = Auther::factory()->create();

        $response = $this->actingAs($this->createUser())->get(route('authors.edit', $author));

        $response->assertStatus(200);
        $response->assertViewIs('auther.edit');
        $response->assertViewHas('auther', $author);
    }

    /**
     * Test the update method.
     *
     * @return void
     */
    public function test_update_modifies_existing_author()
    {
        $author = Auther::factory()->create();
        $data = [
            'name' => 'Updated Name',
        ];

        $response = $this->actingAs($this->createUser())->post(route('authors.update', $author->id), $data);

        $response->assertRedirect(route('authors'));
        $response->assertSessionHas('success', 'Author Updated successfully.');
        $this->assertDatabaseHas('authers', ['id' => $author->id, 'name' => 'Updated Name']);
    }

    /**
     * Test the destroy method.
     *
     * @return void
     */
    public function test_destroy_deletes_existing_author()
    {
        $author = Auther::factory()->create();

        $response = $this->actingAs($this->createUser())->delete(route('authors.destroy', $author->id));

        $response->assertRedirect(route('authors'));
        $response->assertSessionHas('success', 'Author deleted successfully.');
        $this->assertDatabaseMissing('authers', ['id' => $author->id]);
    }

    /**
     * Create a user for authentication.
     *
     * @return \App\Models\User
     */
    protected function createUser()
    {
        return \App\Models\User::factory()->create();
    }
}
