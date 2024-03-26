<?php

namespace Database\Factories;

use App\Models\Type;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

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

        $name = fake()->text(20);

        $slug = Str::slug($name);

        $image_file = fake()->imageUrl(250, 250);

        // Creiamo una cartella ogni qualvolta refreshiamo il db
        Storage::makeDirectory('project_images');

        // Pluck -> dammi una collectio di id ->toArray restitusce un array di id
        $type_ids = Type::pluck('id')->toArray();

        // Aggiungo ai types anche la categoria null
        $type_ids[] = null;

        return [
            'name' => $name,
            'slug' => $slug,
            'type_id' => Arr::random($type_ids),
            'content' => fake()->paragraphs(1, true),
            'image' => Storage::putFileAs('project_images', $image_file, "$slug.png"),
            'is_completed' => fake()->boolean(),
        ];
    }
}
