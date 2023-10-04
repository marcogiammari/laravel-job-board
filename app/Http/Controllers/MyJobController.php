<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobRequest;
use App\Models\Job;
use Illuminate\Http\Request;

class MyJobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobs = request()->user()->employer->jobs()
            ->with('employer', 'jobApplications', 'jobApplications.user')
            ->get();

        return view('my_job.index', ['jobs' => $jobs]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('my_job.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobRequest $request)
    {
        // creiamo il job tramite la relationship employer (NB: senza parentesi perché la usiamo come proprietà)
        // così facendo sarà automaticamente associato all'employer/utente autenticato
        $request->user()->employer->jobs()->create($request->validated());

        return redirect()->route('my-jobs.index')->with('success', 'Job created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    // $myJob come nel nome della rotta -> my-jobs/{my_job}
    public function edit(Job $myJob)
    {
        return view('my_job.edit', ['job' => $myJob]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobRequest $request, Job $myJob)
    {
        $myJob->update($request->validated());

        return redirect()->route('my-jobs.index')
            ->with('success', 'Job updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
