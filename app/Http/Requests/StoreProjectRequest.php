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
            'title'       => 'required|string|max:255',
            'category'    => 'required|string', 
            'year'        => 'required|digits:4', 
            'location'    => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'cover'       => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'images'      => 'nullable|array|max:10',
            'images.*'    => 'image|mimes:jpeg,png,jpg,webp|max:5120',
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