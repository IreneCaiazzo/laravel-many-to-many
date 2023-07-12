@extends('admin.layouts.base')

@section('contents')

    <h1>{{ $type->title }}</h1>
    <p>{{ $type->description }}</p>

    <h2>Projects of this type</h2>
    <ul>
      
        @foreach ($type->projects as $project)
            <li><a href="{{route('admin.projects.show', ['project' => $project])}}">{{ $project->title }}</a></li>   
        @endforeach

    </ul>
@endsection