<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Project;
use App\Models\User;
use App\Models\ProjectAttributeValue;
use App\Models\Timesheet;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'name' => "Project " .  $this->faker->company,
            'status' => 2, // all of the projects are active. 2 is the index of enum (0,1,2,3)

        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Project $project) {
            // Attach a random number of users (between 1 and 5) to the project
            $users = User::inRandomOrder()->limit(rand(3, 10))->get();

            foreach ($users as $user) {
                // Attach user to project
                $project->users()->attach($user->id);

                // Create a Timesheet entry for the user in this project
                Timesheet::create([
                    'user_id' => $user->id,
                    'project_id' => $project->id,
                    'task_name' => 'Task for ' . $project->name,
                    'date' => now()->format('Y-m-d'),
                    'hours' => rand(1, 8), // Assign random hours between 1-8
                ]);
            }



            ProjectAttributeValue::create([
                'project_id' => $project->id,
                'attribute_id' => 1,
                'value' => date("Y-m-d"),
            ]);
            ProjectAttributeValue::create([
                'project_id' => $project->id,
                'attribute_id' => 2,
                'value' => $this->faker->dateTimeBetween('+1 day', '+5 months')->format('Y-m-d'),
            ]);
            ProjectAttributeValue::create([
                'project_id' => $project->id,
                'attribute_id' => 3,
                'value' => $this->faker->randomElement(["IT", "Accounts", "Sales", "Media", "Marketing"]),
            ]);
            ProjectAttributeValue::create([
                'project_id' => $project->id,
                'attribute_id' => 4,
                'value' => $this->faker->numberBetween(5, 20),
            ]);
        });
    }
}
