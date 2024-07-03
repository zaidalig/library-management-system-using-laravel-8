<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test the index method.
     *
     * @return void
     */
    public function test_index_displays_categories()
    {
        $categories = Category::factory()->count(10)->create();

        $response = $this->actingAs($this->createUser())->get(route('categories'));

        $response->assertStatus(200);
        $response->assertViewIs('category.index');
        $response->assertViewHas('categories');
    }

    /**
     * Test the create method.
     *
     * @return void
     */
    public function test_create_displays_create_form()
    {
        $response = $this->actingAs($this->createUser())->get(route('category.create'));

        $response->assertStatus(200);
        $response->assertViewIs('category.create');
    }

    /**
     * Test the store method.
     *
     * @return void
     */
    public function test_store_saves_new_category()
    {
        $data = [
            'name' => $this->faker->word,
        ];

        $response = $this->actingAs($this->createUser())->post(route('category.store'), $data);

        $response->assertRedirect(route('categories'));
        $response->assertSessionHas('success', 'Category created successfully.');
        $this->assertDatabaseHas('categories', $data);
    }

    /**
     * Test the edit method.
     *
     * @return void
     */
    public function test_edit_displays_edit_form()
    {
        $category = Category::factory()->create();

        $response = $this->actingAs($this->createUser())->get(route('category.edit', $category));

        $response->assertStatus(200);
        $response->assertViewIs('category.edit');
        $response->assertViewHas('category', $category);
    }

    /**
     * Test the update method.
     *
     * @return void
     */
    public function test_update_modifies_existing_category()
    {
        $category = Category::factory()->create();
        $data = [
            'name' => 'Updated Name',
        ];

        $response = $this->actingAs($this->createUser())->post(route('category.update', $category->id), $data);

        $response->assertRedirect(route('categories'));
        $response->assertSessionHas('success', 'Category updated successfully.');
        $this->assertDatabaseHas('categories', ['id' => $category->id, 'name' => 'Updated Name']);
    }

    /**
     * Test the destroy method.
     *
     * @return void
     */
    public function test_destroy_deletes_existing_category()
    {
        $category = Category::factory()->create();

        $response = $this->actingAs($this->createUser())->delete(route('category.destroy', $category->id));

        $response->assertRedirect(route('categories'));
        $response->assertSessionHas('success', 'Category deleted successfully.');
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
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
