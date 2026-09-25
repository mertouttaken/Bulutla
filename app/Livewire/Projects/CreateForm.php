<?php

namespace App\Livewire\Projects;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Yeni Proje Oluştur')]
class CreateForm extends Component
{
    #[Validate('required|string|max:255', message: 'Lütfen geçerli bir proje adı girin.')]
    public string $name = '';

    #[Validate('required|in:plugin,map,modpack,config', message: 'Lütfen geçerli bir proje türü seçin.')]
    public string $type = 'plugin';

    public string $description = '';

    public function save()
    {
        $this->validate();

        $user = Auth::user();
        $projectLimit = $user->plan?->project_limit ?? 0;

        if ($projectLimit !== -1 && $projectLimit > 0 && $user->projects()->count() >= $projectLimit) {
            session()->flash('error', 'Paketinizin proje limitine ulaştınız.');
            return redirect()->route('projects.show');
        }

        $user->projects()->create([
            'name' => $this->name,
            'type' => $this->type,
            'description' => $this->description,
        ]);

        session()->flash('success', 'Projeniz başarıyla oluşturuldu.');
        return redirect()->route('projects.show');
    }

    public function render()
    {
        return view('livewire.projects.create-form');
    }
}