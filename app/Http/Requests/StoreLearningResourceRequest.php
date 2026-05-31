<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLearningResourceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'skill_id' => 'required|exists:skills,id',
            'title' => 'required|string|max:255',
            'type' => 'required|in:Article,Video,Course,Documentation',
            'url' => 'required|url|max:500',
            'provider' => 'nullable|string|max:100',
        ];
    }
}
