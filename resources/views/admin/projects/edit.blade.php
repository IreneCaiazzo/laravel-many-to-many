@extends('admin.layouts.base')

@section('contents')

    <h1>Add new post</h1>

    {{-- @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif --}}

    <form method="POST" action="{{ route('admin.projects.store', ['project' => $project]) }}" enctype="multipart/form-data" novalidate>
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input
                type="text"
                class="form-control @error('title') is-invalid @enderror"
                id="title"
                name="title"
                value="{{ old('title', $project->title) }}"
                >
            @error('title')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="input-group mb-3">
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
            <label class="input-group-text @error('image') is-invalid @enderror" for="image">Upload</label>
            @error('image')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <select class="form-select" @error('type_id') is-invalid @enderror 
                id="type" 
                name="type_id"
            >

                @foreach($types as $type)
                    <option value="{{ $type->id }}"
                        @if(old('type_id', $project->type->id) == $type->id) selected @endif>
                        {{ $type->name }}
                    </option>
                @endforeach

            </select>
            @error('type_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <h3>Technologies</h3>
            @foreach($technologies as $technology)
                <div class="mb-3 form-check">
                    <input 
                    type="checkbox" 
                    class="form-check-input"
                    id="technology{{ $technology->id }}" 
                    name="technologies[]" 
                    value="{{ $technology->id }}" 
                    @if (in_array($technology->id, old('technologies', $project->technologies->pluck('id')->all())))checked @endif
                >
                    <label class="form-check-label" for="technology{{ $technology->id }}">{{ $technology->name }}</label>
                </div>
            @endforeach
            {{-- @error('type_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror --}}
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <input
                type="text"
                class="form-control @error('description') is-invalid @enderror"
                id="description"
                name="description"
                value="{{ old('description', $project->description) }}"
            >
            @error('description')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="repo" class="form-label">Repo</label>
            <textarea
                class="form-control @error('repo') is-invalid @enderror"
                id="repo"
                rows="3"
                name="repo">{{ old('repo') }}</textarea>
            @error('repo')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button class="btn btn-primary">Save</button>
    </form>

@endsection