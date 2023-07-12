<?php

namespace Database\Seeders;

use App\Models\Type;
use Faker\Generator;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Generator $faker)
    {
        $types = [
            [
                'name' => 'Undefined',
            ],
            [
                'name' => 'Frontend',
            ],
            [
                'name' => 'Backend',
            ],
            [
                'name' => 'Fullstack',
            ],
        ];


        foreach ($types as $type) {
            Type::create($type);
        }
    }
}
