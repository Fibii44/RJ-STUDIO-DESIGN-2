<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            'first_name'       => 'required|string|max:100',
            'last_name'        => 'required|string|max:100',
            'email'            => 'required|email|max:255',
            'phone'            => 'required|string|max:20',
            'location'         => 'nullable|string|max:255', // Crucial for construction sites
            'service_type'     => 'required',
            'appointment_date' => 'required|date|after:today',
            'message'          => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'appointment_date.after' => 'Please select a future date for your consultation.',
            'first_name.required'    => 'We need your name to address you properly.',
            'location.required'      => 'Please provide the site location for Design & Build projects.',
        ];
    }
}