<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = auth()->user()->projects()->withCount('files')->latest()->get();
        return view('projects.index', compact('projects'));
    }
    public function createIndex()
    {
        return view('projects.create');
    }
}
