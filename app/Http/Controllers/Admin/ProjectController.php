<?php

namespace App\Http\Controllers\Admin;

use App\Models\Type;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{
    private $validations = [
        'title'       => 'required|string|min:5|max:100',
        'type_id'     => 'required|integer|exists:types,id',
        'description' => 'required|string',
        'repo'        => 'required|string|min:5|max:100',
    ];

    private $validation_messages = [
        'required' => 'Il campo :attribute è obbligatorio',
        'min' => 'Il campo :attribute deve avere almeno :min caratteri',
        'max' => 'Il campo :attribute non può superare i :max caratteri',
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
        $types = Type::all();

        return view('admin.projects.create', compact('types'));
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

        //salvare dati in db se validi
        $newProject = new Project();

        $newProject->title = $data['title'];
        $newProject->type_id = $data['type_id'];
        $newProject->description = $data['description'];
        $newProject->repo = $data['repo'];

        $newProject->save();

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
        $types = Type::all();
        return view('admin.projects.edit', compact('project', 'types'));
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

        //aggiornare dati in db se validi

        $project->title = $data['title'];
        $project->type_id = $data['type_id'];
        $project->description = $data['description'];
        $project->repo = $data['repo'];

        $project->update();

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
        $project->delete();

        return to_route('admin.projects.index')->with('delete_success', $project);
    }
}
