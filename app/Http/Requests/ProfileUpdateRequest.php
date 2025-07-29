<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
        ];
        
        // Ajouter des règles de validation pour les artisans
        if ($this->user()->isArtisan()) {
            $rules = array_merge($rules, [
                'bio' => ['nullable', 'string', 'max:1000'],
                'telephone' => ['nullable', 'string', 'max:20'],
                'adresse' => ['nullable', 'string', 'max:255'],
                'ville' => ['nullable', 'string', 'max:100'],
                'code_postal' => ['nullable', 'string', 'max:10'],
                'specialite' => ['nullable', 'string', 'max:100'],
                'experience' => ['nullable', 'integer', 'min:0', 'max:100'],
                'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
                'delete_photo' => ['nullable', 'boolean'],
            ]);
        }
        
        return $rules;
    }
}
