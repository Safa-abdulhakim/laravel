<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCareerPathRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'image' => 'nullable|image|max:2048',
            'difficulty_level' => 'required|in:Beginner,Intermediate,Advanced',
            'estimated_duration' => 'nullable|string|max:100',
            'status' => 'required|in:active,inactive',
        ];
    }
}
