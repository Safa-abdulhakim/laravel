<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSkillRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'stage_id' => 'required|exists:stages,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'estimated_hours' => 'nullable|integer|min:0',
            'difficulty' => 'required|in:Beginner,Intermediate,Advanced',
            'order' => 'nullable|integer|min:0',
        ];
    }
}
