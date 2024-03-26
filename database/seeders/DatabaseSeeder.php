<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;


use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        //! DURANTE LO SVILUPPO UTILIZZO QUESTE CREDENZIALI
        \App\Models\User::factory()->create([
            'name' => 'Gianluca',
            'email' => 'gianluca@maffucci.it',
        ]);

        // Inserisco il seeder del tipo e della tecnologia
        //! ATTENZIONE: inserisco il seeder prima di creare i progetti
        $this->call([TypeSeeder::class, TechnologySeeder::class]);

        //! CREO 10 FAKE PROJECT
        \App\Models\Project::factory(15)->create();
    }
}