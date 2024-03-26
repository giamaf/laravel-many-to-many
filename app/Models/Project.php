<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'slug', 'content', 'is_completed', 'type_id'];

    public function getFormatDate($date, $format = 'd-m-Y')
    {
        return Carbon::create($this->$date)->format($format);
    }

    public function renderImage()
    {
        return asset('storage/' . $this->image);
    }

    //! Si definisce come un metodo ma si legge come proprietà. Es: ($project->type->label)
    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    //! Si definisce come un metodo ma si legge come proprietà. Es: ($project->type->label)
    public function technologies()
    {
        return $this->belongsToMany(Technology::class);
    }

    // Completed scope
    public function scopeCompleted(Builder $query, $status)
    {
        // Se NON mi arriva nulla allora restituisco subito la query...
        if (!$status) return $query;
        // Se mi arriva qualcosa dal filtro completed...
        // Creo una query per filtrare in base a ciò che mi arriva...
        // Se mi arriva yes...
        $value = $status === 'yes';
        // Filtro per i completati
        return $query->whereIsCompleted($value);
    }

    // Type scope
    public function scopeType(Builder $query, $type_id)
    {
        // Se NON mi arriva nulla allora restituisco subito la query...
        if (!$type_id) return $query;
        // Se mi arriva qualcosa dal filtro type...
        // Creo una query per filtrare in base a ciò che mi arriva...

        // Filtro per i types
        return $query->whereTypeId($type_id);
    }
}