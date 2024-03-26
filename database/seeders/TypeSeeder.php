<?php

namespace Database\Seeders;

use App\Models\Type;
//! ATTENZIONE: Per utilizzare il faker nel seeder bisogna importarlo
use Faker\Generator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Generator $faker): void
    {
        $labels = ['FrontEnd', 'BackEnd', 'FullStack'];

        foreach ($labels as $label) {
            $type = new Type();

            $type->label = $label;
            $type->color = $faker->hexColor();

            $type->save();
        }
    }
}
