<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test the login method with valid credentials.
     *
     * @return void
     */
    public function test_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $response = $this->post(route('login'), [
            'username' => $user->username,
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test the login method with invalid credentials.
     *
     * @return void
     */
    public function test_login_with_invalid_credentials()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $response = $this->post(route('login'), [
            'username' => $user->username,
            'password' => 'wrongpassword',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('username');
        $this->assertGuest();
    }

    /**
     * Test the logout method.
     *
     * @return void
     */
    public function test_logout()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->post(route('logout'));

        $response->assertRedirect('/');
        $this->assertGuest();
    }

    /**
     * Test the changePassword method with valid data.
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

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Password changed successfully');
        $this->assertTrue(Hash::check('newpassword', $user->fresh()->password));
    }

    /**
     * Test the changePassword method with incorrect current password.
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
     * Test the changePassword method with mismatched passwords.
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
}
