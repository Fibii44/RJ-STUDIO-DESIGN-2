<?php

namespace App\Http\Controllers;


use App\Models\Appointment;
use App\Http\Requests\StoreAppointmentRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class AppointmentController extends Controller
{
    public function create()
    {
        return view('appointments.create');
    }

    public function store(StoreAppointmentRequest $request) 
    {
        $formattedDate = Carbon::parse($request->appointment_date)->format('Y-m-d H:i:s');

        // The $request->validated() data now includes your new UI fields
        $appointment = Appointment::create([
            'user_id'          => Auth::id(),
            'first_name'       => $request->first_name,
            'last_name'        => $request->last_name,
            'email'            => $request->email,
            'phone'            => $request->phone,
            'location'         => $request->location,
            'service_type'     => $request->service_type,
            'appointment_date' => $formattedDate,
            'message'          => $request->message,
            'status'           => 'pending',
        ]);

        // Send Email Notification to Admin
        try {
            $adminEmail = env('ADMIN_NOTIFICATION_EMAIL', config('mail.from.address'));
            \Illuminate\Support\Facades\Mail::to($adminEmail)->send(new \App\Mail\NewAppointmentNotification($appointment));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Mail failed: ' . $e->getMessage());
        }

        return redirect()->route('client.appointments')->with('success', 'Your project brief has been received! I will review the details and contact you shortly.');
    }

    public function cancel(Appointment $appointment)
    {
        // Ensure the user owns this appointment or is admin
        if ($appointment->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        // Distinguish between Client Cancel and Admin Decline
        $status = Auth::user()->role === 'admin' ? 'declined' : 'cancelled';
        $appointment->update(['status' => $status]);

        $message = $status === 'declined' 
            ? 'The consultation request has been declined.' 
            : 'The consultation has been cancelled.';

        return redirect()->back()->with('success', $message);
    }

    public function confirm(Appointment $appointment)
    {
        // Only admin can confirm
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $appointment->update(['status' => 'confirmed']);

        // Send Confirmation Email to Client
        try {
            \Illuminate\Support\Facades\Mail::to($appointment->email)->send(new \App\Mail\AppointmentConfirmedNotification($appointment));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Client Confirmation Mail failed: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'The consultation has been confirmed and the client has been notified.');
    }

    public function index()
    {
        // Order by most recent request (created_at) at the top
        $appointments = Appointment::with('user')->latest()->get();
        return view('admin.appointments', compact('appointments'));
    }

    public function calendar()
    {
        $appointments = Appointment::whereNotIn('status', ['cancelled', 'declined'])
            ->orderBy('appointment_date', 'asc')
            ->get();
        return view('admin.calendar', compact('appointments'));
    }

    public function clientCalendar()
    {
        // Only get the current user's appointments that are not cancelled or declined
        $appointments = Auth::user()->appointments()
            ->whereNotIn('status', ['cancelled', 'declined'])
            ->orderBy('appointment_date', 'asc')
            ->get();
            
        return view('client.calendar', compact('appointments'));
    }
}