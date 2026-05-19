<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'service_type' => ['required', 'in:web_design,web_development,mobile_app,custom_system'],
            'budget' => ['nullable', 'string', 'max:100'],
            'description' => ['required', 'string', 'min:20', 'max:5000'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Please enter your name.',
            'email.required' => 'Please enter your email address.',
            'service_type.required' => 'Please select a service type.',
            'service_type.in' => 'Please select a valid service type.',
            'description.required' => 'Please describe your project.',
            'description.min' => 'Project description must be at least 20 characters.',
        ];
    }
}
