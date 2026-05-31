<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSkillRequest extends FormRequest
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
            'estimated_hours' => 'nullable|integer|min:0',
            'difficulty' => 'required|in:Beginner,Intermediate,Advanced',
            'order' => 'nullable|integer|min:0',
        ];
    }
}
