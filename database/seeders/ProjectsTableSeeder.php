<?php

namespace Database\Seeders;

use App\Models\Type;

use Faker\Generator;
use App\Models\Project;
use App\Models\Technology;
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

        $types = Type::all();
        $types->shift();

        $technologies = Technology::all()->pluck('id');

        for ($i = 0; $i < 50; $i++) {

            $title = $faker->words(rand(2, 10), true);
            // $slug = Project::slugger($title);

            $slug = '';

            // Generare uno slug valido, non vuoto
            while (empty($slug)) {
                $slug = Project::slugger($title);
            }

            $project = Project::create([

                'type_id' => $faker->randomElement($types)->id,
                'title' => $title,
                'slug' => $slug,
                'description' => $faker->paragraphs(rand(2, 5), true),
                'repo' => $faker->words(rand(2, 10), true),

            ]);

            //associare projects alle technologies

            // $project->technologies()->sync(["1", "2", "3", "4", "5", "6", "7"]);
            $randomTechnologies = $technologies->random(rand(1, 5))->pluck('id')->toArray();
            $project->technologies()->sync($randomTechnologies);
        }
    }
}
