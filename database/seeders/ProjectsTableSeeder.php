<?php

namespace Database\Seeders;

use App\Models\Type;

use Faker\Generator;
use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Generator $faker)
    {

        for ($i = 0; $i < 50; $i++) {

            $types = Type::all();
            Project::create([

                'type_id' => $faker->randomElement($types)->id,
                'title' => $faker->words(rand(2, 10), true),
                'description' => $faker->paragraphs(rand(2, 20), true),
                'repo' => $faker->words(rand(2, 10), true),

            ]);
        }
    }
}
