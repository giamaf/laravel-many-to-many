@if ($project->exists)
    <form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data"
        class="my-4">
        @method('PUT')
    @else
        <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data" class="my-4">
@endif
@csrf
<div class="row">
    <div class="col-6">
        <div class="mb-3">
            <label for="name" class="form-label">Project Name</label>
            <input type="text"
                class="form-control @error('name') is-invalid @elseif (old('name', '')) is-valid @enderror"
                name="name" id="name" placeholder="Project Name" value="{{ old('title', $project->name) }}">
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @else
                <div class="form-text">
                    <p>Add project name</p>
                </div>
            @enderror
        </div>
    </div>
    <div class="col-6">
        <div class="mb-3">
            <label for="slug" class="form-label">Slug</label>
            <input type="text" class="form-control" id="slug"
                value="{{ Str::slug(old('title', $project->slug)) }}" disabled>
        </div>
    </div>
    <div class="col-12">
        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea class="form-control @error('content') is-invalid @elseif (old('name', '')) is-valid @enderror"
                id="content" rows="10" name="content">{{ old('content', $project->content) }}</textarea>
            @error('content')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @else
                <div class="form-text">
                    <p>Add project content</p>
                </div>
            @enderror
        </div>
    </div>
    <div class="col-11">
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>

            {{-- Input nascosto se non ho un'immagine --}}
            <div @class(['input-group', 'd-none' => !$project->image]) id="previous-image-field">
                <button class="btn btn-outline-secondary" type="button" id="change-image-button">upload</button>
                <input type="text" class="form-control" value="{{ old('image', $project->image ?? '') }}" disabled>
            </div>
            {{-- Input standard --}}
            <input type="file"
                class="form-control  @if ($project->image) d-none @endif @error('image') is-invalid @elseif (old('image', '')) is-valid @enderror"
                id="image" name="image" placeholder="http:// or https://">
            @error('image')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @else
                <div class="form-text">
                    <p>Add project image</p>
                </div>
            @enderror
        </div>
    </div>
    <div class="col-1">
        <img src="{{ old('image', $project->image) ? $project->renderImage() : 'https://marcolanci.it/boolean/assets/placeholder.png' }}"
            alt="project-img" id="preview" class="img-fluid rounded">
    </div>
    <div class="col-3">
        <label for="type_id" class="form-label d-block">Types</label>
        <select class="form-select mb-3" name="type_id" id="type_id"
            @error('type_id') is-invalid @elseif (old('type_id', '')) is-valid @enderror>
            <option value="">--Project Type</option>
            @foreach ($types as $type)
                <option value="{{ $type->id }}" @if (old('type_id', $project->type?->id) == $type->id) selected @endif>
                    {{ $type->label }}</option>
            @endforeach
        </select>
        @error('type_id')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-12">
        <div class="form-group mb-3 @error('technologies') is-invalid @enderror">
            <label for="technology_id" class="form-label d-block">Technologies</label>
            @foreach ($technologies as $technology)
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="{{ "tech-$technology->id" }}"
                        value="{{ $technology->id }}" name="technologies[]"
                        @if (in_array($technology->id, old('technologies', $prev_technologies ?? []))) checked @endif>
                    <label class="form-check-label" for="{{ "tech-$technology->id" }}"><img class="my-image"
                            src="{{ $technology->renderLogos() }}" alt=""></label>
                </div>
            @endforeach
        </div>
        @error('technologies')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-12">
        <div class="form-check form-switch my-3">
            <label class="form-check-label" for="completed">Completed</label>
            <input class="form-check-input" type="checkbox" role="switch" id="completed" name="is_completed"
                value="1" @if (old('is_completed', $project->is_completed)) checked @endif>
        </div>
    </div>
</div>
<div class="d-flex justify-content-between align-items-center my-4">
    <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary"><i
            class="fas fa-arrow-left me-1"></i>Back to list</a>
    <div class="d-flex align-items-center gap-1">
        <button class="btn btn-warning" type="reset"><i class="fa-solid fa-arrow-rotate-left me-1"
                id="reset-button"></i>Clear</button>
        <button class="btn btn-success"><i class="fas fa-floppy-disk me-1"></i>Confirm</button>
    </div>
</div>
</form>

@section('scripts')
    {{-- Script creazione slug --}}
    @vite('resources/js/make_slug.js')
    @vite('resources/js/image_preview.js')
@endsection
