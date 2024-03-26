@extends('layouts.app')

@section('title', 'Edit Project')

@section('content')
    <header>
        <h3 class="border-bottom py-1">Edit Project</h3>
    </header>

    @include('includes.projects.form')

@endsection

@section('scripts')
    @vite('resources/js/image_preview.js')
@endsection
