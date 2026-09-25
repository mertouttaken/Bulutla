<?php

namespace App\Livewire\Admin;

use App\Models\Plan;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Planı Düzenle')]
class PlanEditForm extends Component
{
    public Plan $plan;

    #[Validate('required|string|max:255', message: 'Lütfen plan adını girin.')]
    public string $name = '';

    public string $slug = '';

    #[Validate('required|numeric|min:0', message: 'Geçerli bir tutar girin.')]
    public $price = '';

    public ?string $storage_limit = '';
    public int $project_limit = 0;
    public int $sort_order = 0;
    public ?string $description = '';
    public ?string $features = '';
    public bool $is_default = false;

    public function mount(Plan $plan)
    {
        $this->plan = $plan;
        $this->name = $plan->name;
        $this->slug = $plan->slug;
        $this->price = $plan->price;
        $this->storage_limit = $plan->storage_limit;
        $this->project_limit = (int) $plan->project_limit;
        $this->sort_order = (int) $plan->sort_order;
        $this->description = $plan->description;
        $this->features = $plan->features;
        $this->is_default = (bool) $plan->is_default;
    }

    public function update()
    {
        $this->validate([
            'slug' => 'required|string|unique:plans,slug,' . $this->plan->id,
        ]);

        if ($this->is_default && !$this->plan->is_default) {
            Plan::where('id', '!=', $this->plan->id)->where('is_default', 1)->update(['is_default' => 0]);
        }

        $this->plan->update([
            'name' => $this->name,
            'slug' => $this->slug,
            'price' => $this->price,
            'storage_limit' => $this->storage_limit,
            'project_limit' => $this->project_limit,
            'sort_order' => $this->sort_order,
            'description' => $this->description,
            'features' => $this->features,
            'is_default' => $this->is_default,
        ]);

        session()->flash('success', 'Plan başarıyla güncellendi.');
        return redirect()->route('admin.plans.actions');
    }

    public function render()
    {
        return view('livewire.admin.plan-edit-form');
    }
}