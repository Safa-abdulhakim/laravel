<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CvRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cv_file' => 'required|file|mimes:pdf|max:10240',
        ];
    }

    public function messages(): array
    {
        return [
            'cv_file.required' => 'Please select a PDF file to upload.',
            'cv_file.mimes' => 'Only PDF files are allowed.',
            'cv_file.max' => 'CV file size must not exceed 10MB.',
        ];
    }
}
