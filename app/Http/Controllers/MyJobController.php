<?php

namespace App\Http\Controllers;
use App\Models\Job;
use App\Models\User;
use App\Http\Requests\JobRequest;

use Illuminate\Http\Request;

class MyJobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAnyEmployer', Job::class);
        return view(
            'my_job.index',
            [
                'jobs' => auth()->user()->employer
                    ->jobs()
                    ->with(['employer', 'jobApplications', 'jobApplications.user'])
                    ->withTrashed()
                    ->get()
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
        $this->authorize('create', Job::class);
        return view('my_job.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Job::class);
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'salary' => 'required|numeric|min:5000',
            'experience' => 'required|in:'.implode(',', Job::$experience),
            'category' => 'required|in:'.implode(',', Job::$category),

        ]);
        $user = auth()->user();
        if (!$user instanceof User) {
            // Handle unexpected user instance
            return abort(500);
        }
        $user->employer->jobs()->create($validatedData);

        return redirect()->route('my-jobs.index')->with('success','Job created successfully')->withTrashed()->get();

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Job $myJob)
    {
        $this->authorize('update', $myJob);
        return view('my_job.edit', ['job' => $myJob]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Job $myJob)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'salary' => 'required|numeric|min:5000',
            'experience' => 'required|in:'.implode(',', Job::$experience),
            'category' => 'required|in:'.implode(',', Job::$category),

        ]);
        $this->authorize('update', $myJob);
        $myJob->update($validatedData);
        return redirect()->route('my-jobs.index')
            ->with('success', 'Job updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $myJob)
    {
        $myJob->delete();

        return redirect()->route('my-jobs.index')
            ->with('success', 'Job deleted.');
    }
}
