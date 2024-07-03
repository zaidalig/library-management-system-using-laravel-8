<?php

namespace Database\Factories;

use App\Models\book_issue;
use App\Models\book;
use App\Models\student;
use Illuminate\Database\Eloquent\Factories\Factory;

class book_issueFactory extends Factory
{
    protected $model = book_issue::class;

    public function definition()
    {
        return [
            'student_id' => student::factory(),
            'book_id' => book::factory(),
            'issue_date' => $this->faker->date(),
            'return_date' => $this->faker->date(),
            'issue_status' => 'N',
        ];
    }
}
