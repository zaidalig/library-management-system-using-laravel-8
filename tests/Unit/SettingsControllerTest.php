<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class SettingsControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test the index method.
     *
     * @return void
     */
    public function test_index_displays_settings()
    {
        $settings = Settings::factory()->create();

        $response = $this->actingAs($this->createUser())->get(route('settings'));

        $response->assertStatus(200);
        $response->assertViewIs('settings');
        $response->assertViewHas('data', $settings);
    }

    /**
     * Test the update method.
     *
     * @return void
     */
    public function test_update_modifies_existing_settings()
    {
        $settings = Settings::factory()->create();
        $data = [
            'return_days' => 14,
            'fine' => 50,
        ];

        $response = $this->actingAs($this->createUser())->post(route('settings', $settings->id), $data);

        $response->assertRedirect(route('settings'));
        $response->assertSessionHas('success', 'Settings updated successfully.');
        $this->assertDatabaseHas('settings', [
            'id' => $settings->id,
            'return_days' => 14,
            'fine' => 50,
        ]);
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
