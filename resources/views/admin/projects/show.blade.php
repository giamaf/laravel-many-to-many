@extends('layouts.app')

@section('title', "Detail $project->name ")

{{-- Content --}}
@section('content')

    {{-- Header --}}
    <header>
        <h3 class="border-bottom py-1">{{ $project->name }}</h3>
        <small>
            <p class="my-1"><b>Type:
        </small></b>
        @if ($project->type)
            <span class="badge rounded-pill"
                style="background-color: {{ $project->type->color }}">{{ $project->type->label }}</span>
        @else
            <span class="badge rounded-pill text-bg-dark">No type</span>
        @endif
        </p>
        <small>
            <p><b>Technology:
        </small></b>
        @forelse ($project->technologies as $technology)
            <img class="img-fluid my-image" src="{{ $technology->renderLogos() }}" alt="">
        @empty
            <span class="badge rounded-pill text-bg-dark">No type</span>
        @endforelse

        </p>
    </header>

    {{-- Main --}}
    <section class="single-project clearfix">
        @if ($project->image)
            <img src="{{ $project->renderImage() }}" alt="{{ $project->title }}" class="img-fluid float-start rounded me-2">
        @endif
        <p>{{ $project->content }}</p>
    </section>
    <div class="date">
        <figcaption class="fw-lighter">
            <span>created:</span> {{ $project->getFormatDate('created_at', 'd-m-Y H:i') }}
        </figcaption>
        <figcaption class="fw-lighter">
            <span>updated:</span> {{ $project->getFormatDate('updated_at', 'd-m-Y H:i') }}
        </figcaption>
    </div>
@endsection

{{-- Footer --}}
@section('footer')
    <section class="d-flex align-items-center justify-content-between">
        <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary"><i
                class="fas fa-arrow-left me-1"></i>Back</a>

        <div class="d-flex gap-1">
            <a href="{{ route('admin.projects.edit', $project->id) }}" class="btn btn-warning"><i
                    class="fas fa-pencil me-1"></i>Edit</a>
            <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" class="delete-form"
                data-bs-toggle="modal" data-bs-target="#modal">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger"><i class="fas fa-trash-can me-1"></i>Delete</button>
            </form>
        </div>
    </section>
@endsection

@section('scripts')
    @vite('resources/js/delete_confirmation.js')
@endsection
