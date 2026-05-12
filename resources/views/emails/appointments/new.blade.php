<x-mail::message>
# New Consultation Request

Hello Randolf,

A new architectural consultation has been booked through the studio portal.

<x-mail::panel>
**Client Details**
*   **Name:** {{ $appointment->first_name }} {{ $appointment->last_name }}
*   **Email:** {{ $appointment->email }}
*   **Phone:** {{ $appointment->phone }}

**Appointment Details**
*   **Service Type:** {{ $appointment->service_type }}
*   **Scheduled for:** {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y @ h:i A') }}
</x-mail::panel>

**Message from Client:**
{{ $appointment->message }}

<x-mail::button :url="config('app.url') . '/admin/appointments'">
Review Appointment
</x-mail::button>

Regards,<br>
{{ config('app.name') }}
</x-mail::message>
