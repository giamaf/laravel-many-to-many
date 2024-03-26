<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    //! Si definisce come un metodo ma si legge come proprietà. Es: ($type->projects)
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
