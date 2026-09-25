<?php

namespace App\Livewire\Admin;

use App\Models\Plan;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Hızlı İşlemler & Yeni Plan')]
class PlanActions extends Component
{
    #[Validate('required|string|max:255', message: 'Lütfen plan adını girin.')]
    public string $name = '';

    #[Validate('required|string|unique:plans,slug', message: 'Bu slug zaten kullanımda.')]
    public string $slug = '';

    #[Validate('required|numeric|min:0', message: 'Geçerli bir tutar girin.')]
    public $price = '';

    public int $sort_order = 0;
    public string $storage_limit = '';
    public int $project_limit = 5;
    public string $description = '';
    public string $features = '';
    public bool $is_default = false;

    public function updatedName($value)
    {
        $this->slug = Str::slug($value);
    }

    public function save()
    {
        $this->validate();

        if ($this->is_default) {
            Plan::where('is_default', 1)->update(['is_default' => 0]);
        }

        Plan::create([
            'name' => $this->name,
            'slug' => $this->slug,
            'price' => $this->price,
            'sort_order' => $this->sort_order,
            'storage_limit' => $this->storage_limit,
            'project_limit' => $this->project_limit,
            'description' => $this->description,
            'features' => $this->features,
            'is_default' => $this->is_default,
        ]);

        $this->reset(['name', 'slug', 'price', 'sort_order', 'storage_limit', 'project_limit', 'description', 'features', 'is_default']);
        session()->flash('success', 'Yeni plan başarıyla kaydedildi.');
    }

    public function deletePlan(int $planId)
    {
        $plan = Plan::find($planId);
        if ($plan && !$plan->is_default) {
            $plan->delete();
            session()->flash('success', 'Plan başarıyla silindi.');
        }
    }

    public function render()
    {
        return view('livewire.admin.plan-actions', [
            'plans' => Plan::orderBy('sort_order')->get(),
        ]);
    }
}