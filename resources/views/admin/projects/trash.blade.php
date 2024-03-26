@extends('layouts.app')

@section('title', 'Trash')

@section('content')
    <header class="d-flex justify-content-between align-items-center border-bottom py-2">
        <h3 class="m-0">Trashed Projects</h3>

        {{-- Buttons --}}
        <div class="d-flex justify-content-between align-items-center gap-1">
            <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-dark"><i
                    class="fas fa-arrow-left me-1"></i>projects</a>
            <a href="#" class="btn btn-success"><i class="fas fa-arrows-rotate me-1"></i>restore all</a>
            <a href="#" class="btn btn-danger"><i class="fas fa-trash me-1"></i>erase all</a>
        </div>
    </header>

    <table class="table table-striped my-4">
        <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">Name</th>
                <th scope="col">Slug</th>
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
                    <td>{{ $project->is_completed ? 'Yes' : 'No' }}</td>
                    <td>{{ $project->getFormatDate('created_at', 'm-Y') }}</td>
                    <td>{{ $project->getFormatDate('updated_at', 'm-Y') }}</td>
                    <td>

                        <div class="d-flex justify-content-end gap-1">
                            <!-- Restore Form -->
                            <form action="{{ route('admin.projects.restore', $project->id) }}" method="POST"
                                id="restore-form">
                                @csrf
                                @method('PATCH')
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success" data-bs-dismiss="modal" value="back"><i
                                            class="fas fa-arrows-rotate me-1"></i>restore</button>
                                </div>
                            </form>

                            {{-- Delete Form --}}
                            <button type="button" class="btn btn-danger delete-buttons"><i
                                    class="fas fa-trash-can"></i></button>
                            <div class="modal fade" id="modal" data-bs-backdrop="static" data-bs-keyboard="false"
                                tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Delete Confirmation</h1>
                                            <button type="button" class="btn-close modal-buttons" data-bs-dismiss="modal"
                                                aria-label="Close" value="exit"></button>
                                        </div>
                                        <div class="modal-body">
                                            Do you want to delete this project?
                                        </div>
                                        <form action="{{ route('admin.projects.drop', $project->id) }}" method="POST"
                                            id="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary modal-buttons"
                                                    data-bs-dismiss="modal" value="back">Back</button>
                                                <button type="submit" class="btn btn-danger modal-buttons"
                                                    value="confirm">Delete</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">
                        <h2 class="text-center my-2">No trashed projects</h2>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection


@section('scripts')
    @vite('resources/js/delete_confirmation.js')
@endsection
