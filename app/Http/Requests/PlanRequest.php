<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PlanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $planId = $this->route('plan')?->id ?? $this->route('plan');

        return [
            'name'          => 'required|string|max:255',
            'slug'          => [
                'required',
                'string',
                'max:255',
                Rule::unique('plans', 'slug')->ignore($planId),
            ],
            'price'         => 'required|numeric|min:0',
            'storage_limit' => 'nullable|string',
            'project_limit' => 'nullable|integer',
            'description'   => 'nullable|string',
            'features'      => 'nullable',
            'sort_order'    => 'nullable|integer',
            'is_default'    => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'        => 'Plan adı zorunludur.',
            'slug.required'        => 'Slug alanı zorunludur.',
            'slug.unique'          => 'Bu slug zaten kullanılıyor.',
            'price.required'       => 'Fiyat alanı zorunludur.',
            'price.numeric'        => 'Fiyat alanı sayısal olmalıdır.',
            'price.min'            => 'Fiyat alanı 0 veya daha büyük olmalıdır.',
            'storage_limit.string' => 'Depolama limiti alanı metin olmalıdır.',
            'project_limit.integer'=> 'Proje limiti alanı sayısal olmalıdır.',
            'description.string'   => 'Açıklama alanı metin olmalıdır.',
            'features.string'      => 'Özellikler alanı metin olmalıdır.',
            'sort_order.integer'   => 'Sıra alanı sayısal olmalıdır.',
        ];
    }
}