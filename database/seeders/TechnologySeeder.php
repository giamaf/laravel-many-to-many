<?php

namespace Database\Seeders;

use App\Models\Technology;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $technologies = [
            ['label' => 'HTML', 'image' => 'storage/app/public/tech_logos/HTML-5-Badge-Logo.png'],
            ['label' => 'CSS', 'image' => 'storage/app/public/tech_logos/CSS3_logo.svg.png'],
            ['label' => 'Bootstrap', 'image' => 'storage/app/public/tech_logos/Bootstrap_logo.svg.png'],
            ['label' => 'Javascript', 'image' => 'storage/app/public/tech_logos/Javascript.svg.png'],
            ['label' => 'Vue', 'image' => 'storage/app/public/tech_logos/Vue.js.svg.png'],
            ['label' => 'SQL', 'image' => 'storage/app/public/tech_logos/Sql_logo.png'],
            ['label' => 'PHP', 'image' => 'storage/app/public/tech_logos/PHP-logo.svg.png'],
            ['label' => 'Laravel', 'image' => 'storage/app/public/tech_logos/Laravel_logo.svg.png'],
        ];

        // Giro nell'array per fare cose...
        foreach ($technologies as $technology) {
            // Istanzio una nuova tecnologia
            $new_technology = new Technology();

            // Inserisco la label e l'immagine
            $new_technology->label = $technology['label'];
            $new_technology->image = $technology['image'];
            // Salvo le modifiche
            $new_technology->save();
        }
    }
}
