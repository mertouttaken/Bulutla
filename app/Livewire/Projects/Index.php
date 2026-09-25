<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;

#[Layout('layouts.app')]
#[Title('Proje Yönetimi')]
class Index extends Component
{
    public string $search = '';

    public bool $showModal = false;

    #[Validate('required|string|max:255', message: 'Lütfen bir proje adı girin.')]
    public string $name = '';

    public string $description = '';

    public function openModal()
    {
        $this->reset(['name', 'description']);
        $this->resetValidation();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function createProject()
    {
        $this->validate();

        $user = Auth::user();
        $projectLimit = $user->plan?->project_limit ?? 0;

        if ($projectLimit !== -1 && $projectLimit > 0 && $user->projects()->count() >= $projectLimit) {
            session()->flash('error', 'Paketinizin proje limitine ulaştınız.');
            $this->closeModal();
            return;
        }

        $user->projects()->create([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        $this->closeModal();
        session()->flash('success', 'Yeni proje başarıyla oluşturuldu.');
    }

    public function deleteProject(int $projectId)
    {
        $user = Auth::user();
        $project = $user->projects()->find($projectId);

        if ($project) {
            Storage::disk('local')->deleteDirectory("files/{$user->id}/{$project->id}");
            $project->files()->delete();
            $project->delete();
            
            session()->flash('success', 'Proje ve tüm dosyaları başarıyla silindi.');
        }
    }

    public function render()
    {
        $user = Auth::user();

        $projects = $user->projects()
            ->withCount('files')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->get();

        return view('livewire.projects.index', [
            'projects' => $projects,
            'user' => $user,
        ]);
    }
}