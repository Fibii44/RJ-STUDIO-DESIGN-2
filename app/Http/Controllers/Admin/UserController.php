<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Get all users who are not admins
        $clients = User::with('appointments')
            ->where('role', '!=', 'admin')
            ->latest()
            ->get()
            ->map(function($user) {
                // Populate phone from their latest appointment if available
                $user->phone = $user->appointments->sortByDesc('appointment_date')->first()?->phone ?? '';
                return $user;
            });
            
        return view('admin.clients', compact('clients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => 'user',
        ]);

        return redirect()->route('admin.clients.index')->with('success', 'Client account created successfully.');
    }

    public function show(User $client)
    {
        if ($client->role === 'admin') {
            abort(403);
        }

        $client->load(['appointments' => function($q) {
            $q->latest('appointment_date');
        }]);

        $parts = explode(' ', $client->name, 2);
        $client->first_name = $parts[0] ?? '';
        $client->last_name = $parts[1] ?? '';

        return view('admin.clients_show', compact('client'));
    }
}
