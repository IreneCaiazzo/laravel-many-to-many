<?php

namespace App\Http\Controllers\Admin;

use App\Models\Type;
use App\Models\Project;
use App\Models\Technology;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    private $validations = [
        'title'          => 'required|string|min:5|max:100',
        'type_id'        => 'required|integer|exists:types,id',
        'image'          => 'nullable|image|max:1024',
        'description'    => 'required|string',
        'repo'           => 'required|string|min:5|max:100',
        'technologies'   => 'nullable|array',
        'technologies.*' => 'integer|exists:technologies,id',
    ];

    private $validation_messages = [
        'required' => 'Il campo :attribute è obbligatorio',
        'min' => 'Il campo :attribute deve avere almeno :min caratteri',
        //'max' => 'Il campo :attribute non può superare i :max caratteri',
        'exists' => 'Valore non valido',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::paginate(5);
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //richiesta al db per estrarre tutte le categorie
        $types        = Type::all();
        $technologies = Technology::all();

        return view('admin.projects.create', compact('types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validare dati del form
        $request->validate($this->validations, $this->validation_messages);

        $data = $request->all();

        //salvare l'img nella cartella degli uploads
        //prendere il percorso dell'img appena salvata
        $imagePath = Storage::put('uploads', $data['image']);

        //salvare dati in db se validi insieme al percorso dell'img
        $newProject = new Project();

        $newProject->title = $data['title'];
        $newProject->type_id = $data['type_id'];
        $newProject->image = $imagePath;
        $newProject->description = $data['description'];
        $newProject->repo = $data['repo'];

        $newProject->save();

        //associare le technologies

        $newProject->technologies()->sync($data['technologies'] ?? []);

        //redirezionare su una rotta di tipo get
        return to_route('admin.projects.show', ['project' => $newProject]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $types        = Type::all();
        $technologies = Technology::all();

        return view('admin.projects.edit', compact('project', 'types', 'technologies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        //validare dati del form
        $request->validate($this->validations, $this->validation_messages);

        $data = $request->all();

        if ($data['image']) {
            //salvare l'eventuale img nuova
            $imagePath = Storage::put('uploads', $data['image']);

            //se c'è l'img nuova eliminare l'img vecchia
            if ($project->image) {
                Storage::delete($project->image);
            }

            //aggiorno il valore nella colonna con l'indirizzo dell'img nuova se presente
            $project->image = $imagePath;
        }

        //aggiornare dati in db se validi

        $project->title = $data['title'];
        $project->type_id = $data['type_id'];
        $project->description = $data['description'];
        $project->repo = $data['repo'];

        $project->update();

        //associare le technologies

        $project->technologies()->sync($data['technologies'] ?? []);

        //redirezionare su una rotta di tipo get
        return to_route('admin.projects.show', ['project' => $project]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {

        if ($project->image) {
            Storage::delete($project->image);
        }

        //disassociare tutte le technologies dal project
        $project->technologies()->detach();
        // same as: $project->technologies()->sync([]);

        //eliminare il project

        $project->delete();

        return to_route('admin.projects.index')->with('delete_success', $project);
    }
}
