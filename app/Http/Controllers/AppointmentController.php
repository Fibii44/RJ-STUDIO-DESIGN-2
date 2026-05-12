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
        Appointment::create([
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

        return redirect()->route('client.appointments')->with('success', 'Your project brief has been received! I will review the details and contact you shortly.');
    }

    public function cancel(Appointment $appointment)
    {
        // Ensure the user owns this appointment
        if ($appointment->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $appointment->update(['status' => 'cancelled']);

        return redirect()->back()->with('success', 'The consultation has been cancelled.');
    }

    public function confirm(Appointment $appointment)
    {
        // Only admin can confirm
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $appointment->update(['status' => 'confirmed']);

        return redirect()->back()->with('success', 'The consultation has been confirmed.');
    }

    public function index()
    {
        // Eager load the user to display client info in the Admin Sidebar
        $appointments = Appointment::with('user')->orderBy('appointment_date', 'asc')->get();
        return view('admin.appointments', compact('appointments'));
    }
}