<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Vite;

class Technology extends Model
{
    use HasFactory;

    public function projects()
    {
        $this->belongsToMany(Project::class);
    }

    public function renderLogos()
    {
        return Vite::asset('resources/' . $this->image);
    }
}