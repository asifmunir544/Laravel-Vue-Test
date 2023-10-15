<?php

namespace Database\Factories;

use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Question::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $categories = ["Bug Report", "Feature Request", "Improvements","Others"];

        return [
            'title' => rtrim($this->faker->sentence(rand(5, 10)), "."),
            'category' => $categories[array_rand($categories)],
            'body' => $this->faker->paragraphs(rand(3, 7), true),
            'views' => rand(0, 10),
            // Add other fields as needed
        ];
    }
}
