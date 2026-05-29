<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePromptRequest extends FormRequest
{
    public function authorize(): bool { return auth()->check(); }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'prompt_content' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'platform' => 'required|in:ChatGPT,Claude,Gemini,Midjourney,Other',
            'status' => 'required|in:public,private',
            'favorite' => 'nullable|boolean',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ];
    }
}
