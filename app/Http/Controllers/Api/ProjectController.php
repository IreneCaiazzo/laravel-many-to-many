<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    public function index()
    {
        //chiamata al db
        $projects = Project::paginate(5);

        //il metodo json ci dà come risposta json e non html
        return response()->json($projects);
    }

    public function show(Project $project)
    {
        //
    }
}
