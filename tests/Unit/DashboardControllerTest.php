<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\auther;
use App\Models\book;
use App\Models\book_issue;
use App\Models\category;
use App\Models\publisher;
use App\Models\student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test the index method.
     *
     * @return void
     */
    public function test_index_displays_dashboard_data()
    {
        // Create related records first
        $category = category::factory()->create();
        $author = auther::factory()->create();
        $publisher = publisher::factory()->create();

        // Create records with related IDs
        book::factory()->count(5)->create([
            'category_id' => $category->id,
            'auther_id' => $author->id,
            'publisher_id' => $publisher->id,
        ]);

        student::factory()->count(5)->create();
        book_issue::factory()->count(5)->create();

        $response = $this->actingAs($this->createUser())->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard');
        $response->assertViewHasAll([
            'authors' => auther::count(),
            'publishers' => publisher::count(),
            'categories' => category::count(),
            'books' => book::count(),
            'students' => student::count(),
            'issued_books' => book_issue::count(),
        ]);
    }
    /**
     * Test the change_password_view method.
     *
     * @return void
     */
    public function test_change_password_view_displays_reset_password_form()
    {
        $response = $this->actingAs($this->createUser())->get(route('change_password_view'));

        $response->assertStatus(200);
        $response->assertViewIs('reset_password');
    }

    /**
     * Test the change_password method with valid data.
     *
     * @return void
     */
    public function test_change_password_with_valid_data()
    {
        $user = User::factory()->create([
            'password' => Hash::make('oldpassword'),
        ]);

        $this->actingAs($user);

        $response = $this->post(route('change_password'), [
            'c_password' => 'oldpassword',
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ]);

        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHas('success', 'Password changed successfully');
        $this->assertTrue(Hash::check('newpassword', $user->fresh()->password));
    }

    /**
     * Test the change_password method with incorrect current password.
     *
     * @return void
     */
    public function test_change_password_with_incorrect_current_password()
    {
        $user = User::factory()->create([
            'password' => Hash::make('oldpassword'),
        ]);

        $this->actingAs($user);

        $response = $this->post(route('change_password'), [
            'c_password' => 'wrongpassword',
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('c_password');
        $this->assertTrue(Hash::check('oldpassword', $user->fresh()->password));
    }

    /**
     * Test the change_password method with mismatched passwords.
     *
     * @return void
     */
    public function test_change_password_with_mismatched_passwords()
    {
        $user = User::factory()->create([
            'password' => Hash::make('oldpassword'),
        ]);

        $this->actingAs($user);

        $response = $this->post(route('change_password'), [
            'c_password' => 'oldpassword',
            'password' => 'newpassword',
            'password_confirmation' => 'differentpassword',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('password');
        $this->assertTrue(Hash::check('oldpassword', $user->fresh()->password));
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
