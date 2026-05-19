<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'min:10'],
            'client_name' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'url' => ['nullable', 'url', 'max:500'],
            'is_featured' => ['nullable', 'boolean'],
            'status' => ['required', 'in:active,completed,archived'],
            'technologies' => ['nullable', 'array'],
            'technologies.*' => ['exists:technologies,id'],
            'completed_at' => ['nullable', 'date'],
        ];
    }
}
