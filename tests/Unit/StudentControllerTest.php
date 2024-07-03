<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class StudentControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test the index method.
     *
     * @return void
     */
    public function test_index_displays_students()
    {
        $students = Student::factory()->count(10)->create();

        $response = $this->actingAs($this->createUser())->get(route('students'));

        $response->assertStatus(200);
        $response->assertViewIs('student.index');
        $response->assertViewHas('students');
    }

    /**
     * Test the create method.
     *
     * @return void
     */
    public function test_create_displays_create_form()
    {
        $response = $this->actingAs($this->createUser())->get(route('student.create'));

        $response->assertStatus(200);
        $response->assertViewIs('student.create');
    }

    /**
     * Test the store method.
     *
     * @return void
     */
    public function test_store_saves_new_student()
    {
        $data = [
            'name' => $this->faker->name,
            'address' => $this->faker->address,
            'gender' => $this->faker->randomElement(['male', 'female']),
            'class' => $this->faker->word,
            'age' => $this->faker->numberBetween(6, 18),
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->email,
        ];

        $response = $this->actingAs($this->createUser())->post(route('student.store'), $data);

        $response->assertRedirect(route('students'));
        $response->assertSessionHas('success', 'Student created successfully.');
        $this->assertDatabaseHas('students', $data);
    }

    /**
     * Test the show method.
     *
     * @return void
     */
    public function test_show_displays_student()
    {
        $student = Student::factory()->create();

        $response = $this->actingAs($this->createUser())->get(route('student.show', $student->id));

        $response->assertStatus(200);
        $response->assertJson($student->toArray());
    }

    /**
     * Test the edit method.
     *
     * @return void
     */
    public function test_edit_displays_edit_form()
    {
        $student = Student::factory()->create();

        $response = $this->actingAs($this->createUser())->get(route('student.edit', $student));

        $response->assertStatus(200);
        $response->assertViewIs('student.edit');
        $response->assertViewHas('student', $student);
    }

    /**
     * Test the update method.
     *
     * @return void
     */
    public function test_update_modifies_existing_student()
    {
        $student = Student::factory()->create();
        $data = [
            'name' => 'Updated Name',
            'address' => 'Updated Address',
            'gender' => 'male',
            'class' => 'Updated Class',
            'age' => 15,
            'phone' => '1234567890',
            'email' => 'updated@example.com',
        ];

        $response = $this->actingAs($this->createUser())->post(route('student.update', $student->id), $data);

        $response->assertRedirect(route('students'));
        $response->assertSessionHas('success', 'Student updated successfully.');
        $this->assertDatabaseHas('students', ['id' => $student->id] + $data);
    }

    /**
     * Test the destroy method.
     *
     * @return void
     */
    public function test_destroy_deletes_existing_student()
    {
        $student = Student::factory()->create();

        $response = $this->actingAs($this->createUser())->delete(route('student.destroy', $student->id));

        $response->assertRedirect(route('students'));
        $response->assertSessionHas('success', 'Student deleted successfully.');
        $this->assertDatabaseMissing('students', ['id' => $student->id]);
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
