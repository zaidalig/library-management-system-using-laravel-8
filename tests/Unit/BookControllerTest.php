<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Book;
use App\Models\Auther;
use App\Models\Category;
use App\Models\Publisher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class BookControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->category = Category::factory()->create();
        $this->author = Auther::factory()->create();
        $this->publisher = Publisher::factory()->create();
    }

    // Ensure all tests create necessary related models before creating book records
    public function test_index_displays_books()
    {
        Book::factory()->count(10)->create([
            'category_id' => $this->category->id,
            'auther_id' => $this->author->id,
            'publisher_id' => $this->publisher->id,
        ]);

        $response = $this->actingAs($this->createUser())->get(route('books'));

        $response->assertStatus(200);
        $response->assertViewIs('book.index');
        $response->assertViewHas('books');
    }

    // Other methods similarly adjusted...

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
