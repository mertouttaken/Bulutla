<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
        ];
    }
    public function messages(): array
    {
        return [
            'mail.required' => 'Email alanı zorunludur.',
            'mail.email' => 'Geçerli bir email adresi giriniz.',
            'mail.exists' => 'Bu email adresi kayıtlı değil.',
            'password.required' => 'Şifre alanı zorunludur.',
        ];
    }
}