<?php

namespace App\Http\Controllers;
use App\Models\Employer;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use Illuminate\Http\Request;

class EmployerController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Employer::class);
        
    }

    public function create()
    {
        return view('employer.create');
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        if (!$user instanceof User) {
            // Handle unexpected user instance
            return abort(500);
        }

        // Create a new employer associated with the authenticated user
        $user->employer()->create(
            $request->validate([
                'company_name' => 'required|min:3|unique:employers,company_name'
            ])
        );
    
        return redirect()->route('jobs.index')
            ->with('success', 'Your employer account was created!');
    }
}
