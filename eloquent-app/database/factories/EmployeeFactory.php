<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => '',
            'name' => '',
            'title' => '',
            'salary' => '',
        ];
        
    }

    public function programmer(): Factory{
        return $this->state(function (array $attributes){
            return[
                'title' => 'Programmer',
                'salary' => 5000000,
            ];
        });
    }

    public function SenioProgrammer(): Factory{
        return $this->state(function (array $attributes){
            return[
                'title' => 'Senior Programmer',
                'salary' => 10000000,
            ];
        });
    }
}
