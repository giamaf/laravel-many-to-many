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

        $html_link = 'https://it.wikipedia.org/wiki/HTML';
        $css_link = 'https://it.wikipedia.org/wiki/css';
        $bootstrap_link = 'https://it.wikipedia.org/wiki/Bootstrap_(framework)';
        $javascript_link = 'https://it.wikipedia.org/wiki/JavaScript';
        $vue_link = 'https://it.wikipedia.org/wiki/Vue.js';
        $sql_link = 'https://it.wikipedia.org/wiki/Structured_Query_Language';
        $php_link = 'https://it.wikipedia.org/wiki/PHP';
        $laravel_link = 'https://it.wikipedia.org/wiki/Laravel';

        $technologies = [
            ['label' => 'HTML', 'image' => 'tech_logos/HTML-5-Badge-Logo.png', 'link' => $html_link],
            ['label' => 'CSS', 'image' => 'tech_logos/css.png', 'link' => $css_link],
            ['label' => 'Bootstrap', 'image' => 'tech_logos/Bootstrap_logo.svg.png', 'link' => $bootstrap_link],
            ['label' => 'Javascript', 'image' => 'tech_logos/Javascript.svg.png', 'link' => $javascript_link],
            ['label' => 'Vue', 'image' => 'tech_logos/Vue.js.svg.png', 'link' => $vue_link],
            ['label' => 'SQL', 'image' => 'tech_logos/Sql_logo.png', 'link' => $sql_link],
            ['label' => 'PHP', 'image' => 'tech_logos/PHP-logo.svg.png', 'link' => $php_link],
            ['label' => 'Laravel', 'image' => 'tech_logos/Laravel_logo.svg.png', 'link' => $laravel_link],
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