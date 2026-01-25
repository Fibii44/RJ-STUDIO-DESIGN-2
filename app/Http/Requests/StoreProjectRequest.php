<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Set to true so you (the admin) can actually upload
        return true; 
    }

    public function rules(): array
    {
        return [
            'title'    => 'required|string|max:255',
            'category' => 'required|string', // Residential, Commercial, etc.
            'year'     => 'required|digits:4', // Ensures a valid year like 2025
            'image'    => 'required_without:images|nullable|image|mimes:jpeg,png,jpg|max:5120',
            'images'   => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:10240',
        ];
    }

    public function messages(): array
    {
        return [
            'image.required' => 'An architectural render is required for the portfolio.',
            'image.max'      => 'The image is too large. Please keep it under 5MB for fast loading.',
        ];
    }
}