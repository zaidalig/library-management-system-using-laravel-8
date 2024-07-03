<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\book_issue;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class ReportsControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test the index method.
     *
     * @return void
     */
    public function test_index_displays_reports_index()
    {
        $response = $this->actingAs($this->createUser())->get(route('reports'));

        $response->assertStatus(200);
        $response->assertViewIs('report.index');
    }

    /**
     * Test the date_wise method.
     *
     * @return void
     */
    public function test_date_wise_displays_date_wise_report_form()
    {
        $response = $this->actingAs($this->createUser())->get(route('reports.date_wise'));

        $response->assertStatus(200);
        $response->assertViewIs('report.dateWise');
        $response->assertViewHas('books', '');
    }

    /**
     * Test the generate_date_wise_report method.
     *
     * @return void
     */
    public function test_generate_date_wise_report_displays_results()
    {
        $date = now()->format('Y-m-d');
        book_issue::factory()->create(['issue_date' => $date]);

        $response = $this->actingAs($this->createUser())->post(route('reports.date_wise_generate'), [
            'date' => $date,
        ]);

        $response->assertStatus(200);
        $response->assertViewIs('report.dateWise');
        $response->assertViewHas('books');
    }

    /**
     * Test the month_wise method.
     *
     * @return void
     */
    public function test_month_wise_displays_month_wise_report_form()
    {
        $response = $this->actingAs($this->createUser())->get(route('reports.month_wise'));

        $response->assertStatus(200);
        $response->assertViewIs('report.monthWise');
        $response->assertViewHas('books', '');
    }

    /**
     * Test the generate_month_wise_report method.
     *
     * @return void
     */
    public function test_generate_month_wise_report_displays_results()
    {
        $month = now()->format('Y-m');
        book_issue::factory()->create(['issue_date' => $month . '-01']);

        $response = $this->actingAs($this->createUser())->post(route('reports.month_wise_generate'), [
            'month' => $month,
        ]);

        $response->assertStatus(200);
        $response->assertViewIs('report.monthWise');
        $response->assertViewHas('books');
    }

    /**
     * Test the not_returned method.
     *
     * @return void
     */
    public function test_not_returned_displays_not_returned_report()
    {
        book_issue::factory()->count(10)->create();

        $response = $this->actingAs($this->createUser())->get(route('reports.not_returned'));

        $response->assertStatus(200);
        $response->assertViewIs('report.notReturned');
        $response->assertViewHas('books');
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
