<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Storage;

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
    public function showFilesIndex($projectId)
    {
        $project = auth()->user()->projects()->findOrFail($projectId);
        $files = $project->files()->latest()->get();
        return view('projects.files', compact('project', 'files'));
    }
    public function projectDestroy($projectId)
    {
        $user = auth()->user();
        $project = $user->projects()->findOrFail($projectId);

        Storage::disk('local')->deleteDirectory("files/{$user->id}/{$project->id}");

        $project->files()->delete();

        $project->delete();

        return redirect()->route('projects.show')->with('success', 'Proje ve tüm dosyaları başarıyla silindi.');
    }
    public function projectStore(Request $request, $projectId = null)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = auth()->user();
        $projectLimit = $user->plan?->project_limit ?? 0;

        if (!$projectId && $projectLimit !== -1 && $user->projects()->count() >= $projectLimit) {
            return redirect()->route('projects.show')
                ->with('error', 'Proje limitinize ulaştınız. Lütfen planınızı yükseltin.');
        }
        if ($projectId) {
            $project = $user->projects()->findOrFail($projectId);
            $project->update(
                [
                    'name' => $request->input('name'),
                    'description' => $request->input('description', null),
                ]);
        } else {
            $project = $user->projects()->create(
                [
                    'name' => $request->input('name'),
                    'description' => $request->input('description', null),
                ]);
        }

        return redirect()->route('projects.show')->with('success', 'Proje başarıyla kaydedildi.');
    }
}
