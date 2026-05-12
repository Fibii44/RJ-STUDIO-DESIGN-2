<x-mail::message>
# Appointment Confirmed

Dear {{ $appointment->first_name }},

Your request for an architectural consultation with **RJ Studio** has been successfully reviewed and **confirmed**.

<x-mail::panel>
**Consultation Schedule**
*   **Service:** {{ $appointment->service_type }}
*   **Date & Time:** {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y @ h:i A') }}
</x-mail::panel>

We look forward to discussing your vision and exploring the potential of your space.

<x-mail::button :url="config('app.url') . '/my-appointments'">
Manage Appointment
</x-mail::button>

If you have any questions before our meeting, please reply to this email.

Best regards,<br>
**Randolf Jan**<br>
{{ config('app.name') }}
</x-mail::message>
