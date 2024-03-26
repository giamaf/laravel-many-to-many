@extends('layouts.app')

@section('title', 'Projects')

@section('content')
    <header class="d-flex justify-content-between align-items-center border-bottom py-2">
        <h3 class="m-0">Projects</h3>

        {{-- Filtro --}}
        <div class="d-flex justify-content-between align-items-center gap-4">
            <form action="{{ route('admin.projects.index') }}" method="GET">
                <div class="d-flex justify-content-between gap-1">
                    <div class="col-4">
                        <select class="form-select" name="completed_filter">
                            <option value="" @if ($completed_filter === '') selected @endif>All</option>
                            <option value="yes" @if ($completed_filter === 'yes') selected @endif>Yes</option>
                            <option value="no" @if ($completed_filter === 'no') selected @endif>No</option>
                        </select>
                    </div>
                    <div class="col-5">
                        <select class="form-select" name="type_filter">
                            <option value="">All types</option>
                            @foreach ($types as $type)
                                <option value="{{ $type->id }} @if ($type_filter == $type->id) selected @endif">
                                    {{ $type->label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn btn-outline-primary">search</button>
                </div>
            </form>

            {{-- Button per aggiungere un nuovo progetto --}}
            <div class="d-flex justify-content-between align-items-center gap-1">
                <a href="{{ route('admin.projects.create') }}" class="btn btn-success"><i class="fas fa-plus me-1"></i>add
                    New</a>
                <a href="{{ route('admin.projects.trash') }}" class="btn btn-danger"><i
                        class="fas fa-trash me-1"></i>trash</a>
            </div>
        </div>
    </header>

    <table class="table table-striped my-4">
        <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">Name</th>
                <th scope="col">Slug</th>
                <th scope="col">Type</th>
                <th scope="col">Technologies</th>
                <th scope="col">Completed</th>
                <th scope="col">Created</th>
                <th scope="col">Updated</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($projects as $project)
                <tr>
                    <th scope="row">{{ $project->id }}</th>
                    <td>{{ $project->name }}</td>
                    <td>{{ $project->slug }}</td>
                    <td>
                        @if ($project->type)
                            <span class="badge rounded-pill"
                                style="background-color: {{ $project->type->color }}">{{ $project->type->label }}</span>
                        @else
                            <span class="badge rounded-pill text-bg-dark">No type</span>
                        @endif
                    </td>
                    <td>
                        @forelse ($project->technologies as $technology)
                            <img src="{{ $technology->renderLogos() }}" class="img-fluid my-image" alt="">
                        @empty
                            <span class="badge rounded-pill text-bg-secondary">No technologies</span>
                        @endforelse
                    </td>
                    <td>{{ $project->is_completed ? 'Yes' : 'No' }}</td>
                    <td>{{ $project->getFormatDate('created_at', 'm-Y') }}</td>
                    <td>{{ $project->getFormatDate('updated_at', 'm-Y') }}</td>
                    <td>
                        <div class="d-flex justify-content-end gap-1">
                            <a href="{{ route('admin.projects.show', $project->id) }}" class="btn btn-secondary">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.projects.edit', $project->id) }}" class="btn btn-warning"><i
                                    class="fas fa-pencil "></i></a>
                            <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST"
                                class="delete-form" data-bs-toggle="modal" data-bs-target="#modal">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger"><i class="fas fa-trash-can"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9">
                        <h3>No projects</h3>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if ($projects->hasPages())
        {{ $projects->links() }}
    @endif

@endsection


@section('scripts')
    @vite('resources/js/delete_confirmation.js')
@endsection
