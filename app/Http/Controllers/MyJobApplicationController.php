<?php

namespace App\Http\Controllers;
use App\Models\User; 
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyJobApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->check()) {
            // Redirect to login page or display an error message
            return redirect()->route('login');
        }

        $user = auth()->user();
        if (!$user instanceof User) {
            // Handle unexpected user instance
            return abort(500);
        }

        return view(
            'my_job_application.index',
            [
                'applications' => $user->jobApplications()
                    ->with([
                        'job' => function ($query) {
                            $query->withCount('jobApplications')
                                ->withAvg('jobApplications', 'expected_salary')
                                ->withTrashed();
                        },
                        'job.employer'
                    ])
                    ->latest()->get()
            ]
        );
    }

    
    public function destroy(JobApplication $myJobApplication)
    {
        //
        $myJobApplication->delete();

        return redirect()->back()->with(
            'success',
            'Job application removed.'
        );
    }    
}