@extends('admin.layouts.base')

@section('contents')

    <h1>{{  $project->title }}</h1>
    <h2>Type: {{ $project->type->name}}</h2>
    <h3>Technologies:{{ implode(', ', $project->technologies->pluck('name')->all()) }}</h3>
    
    @if ($project->image)
        <img src="{{ asset('storage/' . $project->image)}}" alt="{{  $project->title }}">
    @endif

    <p>{{  $project->description }}</p>
    <h2>{{  $project->repo }}</h2>

@endsection