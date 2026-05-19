<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTestimonialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_name' => ['required', 'string', 'max:255'],
            'client_position' => ['nullable', 'string', 'max:255'],
            'client_company' => ['nullable', 'string', 'max:255'],
            'content' => ['required', 'string', 'min:10', 'max:1000'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:1024'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
