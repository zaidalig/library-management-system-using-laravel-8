<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\book;
use App\Models\student;
use App\Models\book_issue;
use App\Models\settings;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class BookIssueControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->student = student::factory()->create();
        $this->book = book::factory()->create(['status' => 'Y']);
        $this->settings = settings::factory()->create(['return_days' => 7, 'fine' => 10]);
    }

    public function test_index_displays_book_issues()
    {
        book_issue::factory()->count(10)->create([
            'student_id' => $this->student->id,
            'book_id' => $this->book->id,
        ]);

        $response = $this->actingAs($this->createUser())->get(route('book_issued'));

        $response->assertStatus(200);
        $response->assertViewIs('book.issueBooks');
        $response->assertViewHas('books');
    }

    public function test_create_displays_create_form()
    {
        $response = $this->actingAs($this->createUser())->get(route('book_issue.create'));

        $response->assertStatus(200);
        $response->assertViewIs('book.issueBook_add');
        $response->assertViewHasAll(['students', 'books']);
    }

    public function test_store_saves_new_book_issue()
    {
        $data = [
            'student_id' => $this->student->id,
            'book_id' => $this->book->id,
        ];

        $response = $this->actingAs($this->createUser())->post(route('book_issue.store'), $data);

        $response->assertRedirect(route('book_issued'));
        $response->assertSessionHas('success', 'Book issued successfully.');
        $this->assertDatabaseHas('book_issues', $data);
        $this->assertDatabaseHas('books', [
            'id' => $this->book->id,
            'status' => 'N',
        ]);
    }

    public function test_edit_displays_edit_form()
    {
        $bookIssue = book_issue::factory()->create([
            'student_id' => $this->student->id,
            'book_id' => $this->book->id,
        ]);

        $response = $this->actingAs($this->createUser())->get(route('book_issue.edit', $bookIssue->id));

        $response->assertStatus(200);
        $response->assertViewIs('book.issueBook_edit');
        $response->assertViewHasAll(['book', 'fine']);
    }

    public function test_update_modifies_existing_book_issue()
    {
        $bookIssue = book_issue::factory()->create([
            'student_id' => $this->student->id,
            'book_id' => $this->book->id,
        ]);

        $data = [
            'issue_status' => 'Y',
            'return_day' => now(),
        ];

        $response = $this->actingAs($this->createUser())->post(route('book_issue.update', $bookIssue->id), $data);

        $response->assertRedirect(route('book_issued'));
        $response->assertSessionHas('success', 'Record updated successfully.');
        $this->assertDatabaseHas('book_issues', [
            'id' => $bookIssue->id,
            'issue_status' => 'Y',
        ]);
        $this->assertDatabaseHas('books', [
            'id' => $this->book->id,
            'status' => 'Y',
        ]);
    }

    public function test_destroy_deletes_existing_book_issue()
    {
        $bookIssue = book_issue::factory()->create([
            'student_id' => $this->student->id,
            'book_id' => $this->book->id,
        ]);

        $response = $this->actingAs($this->createUser())->delete(route('book_issue.destroy', $bookIssue->id));

        $response->assertRedirect(route('book_issued'));
        $response->assertSessionHas('success', 'Record deleted successfully.');
        $this->assertDatabaseMissing('book_issues', ['id' => $bookIssue->id]);
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
