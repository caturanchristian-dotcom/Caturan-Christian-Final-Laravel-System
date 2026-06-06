<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Handle the main dashboard redirection based on user role.
     */
    public function index()
    {
        $user = Auth::user();

        // Redirect logic based on RBAC
        switch ($user->role->name) {
            case 'admin':
                return redirect()->route('admin.dashboard');

            case 'farmer':
                return redirect()->route('farmer.dashboard');

            case 'customer':
                return redirect()->route('customer.dashboard');

            default:
                return redirect()->route('home');
        }
    }

    /**
     * General stats for the system (used by admin or public reports).
     */
    public function reports()
    {
        // Check if user is admin
        if (Auth::user()->role->name !== 'admin') {
            abort(403);
        }

        return view('admin.reports');
    }

    /**
     * Global user management view for admins.
     */
    public function manageUsers()
    {
        // Handled by AdminController usually, but can be routed here if needed
        return redirect()->route('admin.users.index');
    }
}
