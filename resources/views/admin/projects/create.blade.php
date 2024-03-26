@extends('layouts.app')

@section('title', 'New Project')

@section('content')
    <header>
        <h3 class="border-bottom py-1">New Project</h3>
    </header>

    @include('includes.projects.form')

@endsection

@section('scripts')
    @vite('resources/js/image_preview.js')
@endsection
