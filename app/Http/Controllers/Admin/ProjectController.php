<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Technology;
use App\Models\Type;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Recupero i dati del filtro nella request
        $completed_filter = $request->query('completed_filter');
        $type_filter = $request->query('type_filter');

        // Preparo la query
        $projects = Project::completed($completed_filter)
            ->type($type_filter)
            ->orderByDesc('updated_at')
            ->orderByDesc('created_at')
            ->paginate(10)
            //! Importante aggiungere withQueryString per mantenere il filtro al cambio pagina
            ->withQueryString();

        $types = Type::withCount('projects')->get();
        return view('admin.projects.index', compact('projects', 'completed_filter', 'type_filter', 'types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $project = new Project;
        $types = Type::select('label', 'id')->get();
        $technologies = Technology::select('label', 'id', 'image')->get();
        return view('admin.projects.create', compact('project', 'types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Project $project)
    {

        $request->validate(
            [
                'name' => ['required', 'string', 'min:3', 'max:50', Rule::unique('projects')->ignore($project->id)],
                'content' => 'required|string',
                'image' => 'nullable|image|mimes:png,jpg,jpeg',
                'is_completed' => 'nullable|boolean',
                'type_id' => 'nullable|exists:types,id',
                'technologies' => 'nullable|exists:technologies,id',
            ],
            [
                'name.required' => 'Project name required',
                'name.min' => 'Project name must have at least :min',
                'name.max' => 'Project name must have max :max',
                'name.unique' => 'This Project name already exsist',
                'content.required' => 'Content required',
                'image.image' => 'File is not an image',
                'image.mimes' => 'Invalid file extension. Accepted only: .png, .jpg, .jpeg ',
                'is_completed.boolean' => 'Invalid field',
                'type_id.exists' => 'Invalid type',
                'technology_id.exists' => 'Invalid technology',
            ]
        );

        // Prendo i dati che arrivano dalla request
        $data = $request->all();

        // Istanzio un nuovo progetto
        $project = new Project;

        // Compilo i campi della table
        $project->fill($data);

        // Gestisco lo slug
        $project->slug = Str::slug($project->name);

        // Gestisco is_completed verificando se esiste una chiave nell'array che mi arriva
        $project->is_completed = array_key_exists('is_completed', $data);

        // Controllo se mi arriva un file
        //! ATTENZIONE
        //! Se lo faccio PRIMA del fill allora posso mantenere 'image' nel fillable del model
        //! Se lo faccio DOPO il fill allora nel model devo togliere 'image' dal fillable del model.
        if (Arr::exists($data, 'image')) {

            // Riprendiamo l'estensione del file caricato
            $extension = $data['image']->extension();
            $image_name = "$project->slug.$extension";

            //! Se lascio il primo argomento vuoto allora salverà nel disco di default (storage/app/public)...
            // Se invece inserisco qualcosa allora verrà creata(se non esiste) una cartella apposita per gli elementi da salvare
            // Il secondo argomento invece è il file da salvare
            // Il terzo parametro assegna lo slug come nome del file (montato in precedenza $imagename)
            $image_url = Storage::putFileAs('project_images', $data['image'], $image_name);

            // Inserisco l'immagine nell'istanza
            $project->image = $image_url;
        }

        // Salvo nel db
        $project->save();

        // Dopo aver salvato, se ci sono technologies allora li aggancio nella tabella ponte
        if (Arr::exists($data, 'technologies')) {
            // Utilizzo la relazione e ci aggancio attach
            $project->technologies()->attach($data['technologies']);
        }

        return to_route('admin.projects.show', $project)->with('message', 'Project create successful')->with('type', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        // Recupero le technologies associate al progetto e le mando giù come semplice array
        $prev_technologies = $project->technologies->pluck('id')->toArray();

        $technologies = Technology::select('label', 'id', 'image')->get();
        $types = Type::select('label', 'id')->get();
        return view('admin.projects.edit', compact('project', 'types', 'technologies', 'prev_technologies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {

        $request->validate(
            [
                'name' => ['required', 'string', 'min:3', 'max:50', Rule::unique('projects')->ignore($project->id)],
                'content' => 'required|string',
                'image' => 'nullable|image|mimes:png,jpg,jpeg',
                'is_completed' => 'nullable|boolean',
                'type_id' => 'nullable|exists:types,id',
                'technologies' => 'nullable|exists:technologies,id',
            ],
            [
                'name.required' => 'Project name required',
                'name.min' => 'Project name must have at least :min',
                'name.max' => 'Project name must have max :max',
                'name.unique' => 'This Project name already exsist',
                'name.required' => 'Content required',
                'image.image' => 'File is not an image',
                'image.mimes' => 'Invalid file extension. Accepted only: .png, .jpg, .jpeg ',
                'is_completed.boolean' => 'Invalid field',
                'type_id.exists' => 'Invalid type',
                'technology_id.exists' => 'Invalid technology',
            ]
        );

        // Prendo i dati che arrivano dalla request
        $data = $request->all();

        // Gestisco lo slug
        $project->slug = Str::slug($project->name);

        // Gestisco is_completed verificando se esiste una chiave nell'array che mi arriva
        $project->is_completed = array_key_exists('is_completed', $data);

        // Controllo se mi arriva un file
        //! ATTENZIONE
        //! Se lo faccio PRIMA del fill allora posso mantenere 'image' nel fillable del model
        //! Se lo faccio DOPO il fill allora nel model devo togliere 'image' dal fillable del model.
        if (array_key_exists('image', $data)) {
            //# Controllo se c'è già un'immagine
            if ($project->image) Storage::delete($project->image);

            // Riprendiamo l'estensione del file caricato
            $extension = $data['image']->extension();
            $image_name = "$project->slug.$extension";

            //! Se lascio il primo argomento vuoto allora salverà nel disco di default (storage/app/public)...
            // Se invece inserisco qualcosa allora verrà creata(se non esiste) una cartella apposita per gli elementi da salvare
            // Il secondo argomento invece è il file da salvare
            // Il terzo parametro assegna lo slug come nome del file (montato in precedenza $imagename)
            $image_url = Storage::putFileAs('project_images', $data['image'], $image_name);

            // Inserisco l'immagine nell'istanza
            $project->image = $image_url;
        }

        // Salvo nel db
        $project->update($data);

        // Dopo aver salvato, se ci sono technologies allora sovrascrivo nella tabella ponte
        if (Arr::exists($data, 'technologies')) {
            // Utilizzo la relazione e utilizzo sync per sovascrivere
            $project->technologies()->sync($data['technologies']);

            // Se però non ho technologies allora azzero tutto con detach
        } elseif (!Arr::exists($data, 'technologies') && $project->has('technologies')) $project->technologies()->detach();

        return to_route('admin.projects.show', $project)->with('message', 'Project edited successful')->with('type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {

        $project->delete();

        return to_route('admin.projects.index')->with('message', 'Trashed successful')->with('type', 'warning');
    }

    //* ROTTE SOFT DELETE

    public function trash()
    {
        $projects = Project::onlyTrashed()->get();

        return view('admin.projects.trash', compact('projects'));
    }

    public function restore(Project $project)
    {
        $project->restore();

        return to_route('admin.projects.index')->with('message', "Restore $project->name successful")->with('type', 'success');
    }

    public function drop(Project $project)
    {
        // Elimino eventuali technologies presenti nel progetto
        if ($project->has('technologies')) $project->technologies()->detach();

        // Controllo se c'è un file immagine alla cancellazione definitiva
        // Se c'è allora lo elimino definitivamente dalla cartella
        if ($project->image) Storage::delete($project->image);
        $project->forceDelete();

        return to_route('admin.projects.trash')->with('message', 'Erased definitively successful')->with('type', 'warning');
    }
}