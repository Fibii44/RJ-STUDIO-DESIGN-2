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
        $clients = User::where('role', '!=', 'admin')->latest()->get();
        return view('admin.clients', compact('clients'));
    }
}
