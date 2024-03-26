<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class HomeController extends Controller
{
    public function __invoke()
    {
        $projects = Project::whereIsCompleted(true)->orderByDesc('created_at')->paginate(4);
        return view('guest.home', compact('projects'));
    }
}
