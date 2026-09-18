<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PlanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:plans,slug',
            'price' => 'required|numeric|min:0',
            'storage_limit' => 'nullable|string',
            'project_limit' => 'nullable|integer',
            'description' => 'nullable|string',
            'features' => 'nullable|string',
            'sort_order' => 'nullable|integer'
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Plan adı zorunludur.',
            'slug.required' => 'Slug alanı zorunludur.',
            'slug.unique' => 'Bu slug zaten kullanılıyor.',
            'price.required' => 'Fiyat alanı zorunludur.',
            'price.numeric' => 'Fiyat alanı sayısal olmalıdır.',
            'price.min' => 'Fiyat alanı 0 veya daha büyük olmalıdır.',
            'storage_limit.string' => 'Depolama limiti alanı metin olmalıdır.',
            'project_limit.integer' => 'Proje limiti alanı sayısal olmalıdır.',
            'description.string' => 'Açıklama alanı metin olmalıdır.',
            'features.string' => 'Özellikler alanı metin olmalıdır.',
            'sort_order.integer' => 'Sıra alanı sayısal olmalıdır.',
        ];
    }
}
