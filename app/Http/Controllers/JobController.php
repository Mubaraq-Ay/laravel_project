<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\User;
use \App\Mail\JobPosted;
use App\Mail\OrderShipped;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use \Illuminate\Support\Facades\Mail;


class JobController extends Controller
{
    public function index()
    {

        $jobs = Job::with('employer')->latest()->simplePaginate(3);

        return view('jobs/index', [

            'jobs' => $jobs,

        ]);
    }

    public function create()
    {

        return view('jobs/create');
    }

    public function show(Job $job)
    {

        return view('jobs/show', ['job' => $job]);
    }
 
    public function store()
    {
        request()->validate([
            'title' => ['required', 'min:3'],
            'salary' => ['required'],
        ]);
    
        $job = Job::create([
            'title' => request('title'),
            'salary' => request('salary'),
            'employer_id' => 1,
        ]);
    
        // Attempt to send email; fallback to a default if email is null
        Mail::to(optional($job->employer->user)->email ?: 'info@hybrid.com')->queue(
            new JobPosted($job)
        );
    
        return redirect('/jobs')->with('message', 'Job created and email sent.');
    }
    
    
    public function edit(Job $job)
    {

     
      
        Gate::authorize('edit-job', $job);

  
        return view('jobs.edit', ['job' => $job]);
    }

    public function update(Job $job)
    {

        Gate::authorize('edit-job', $job);
 
        request()->validate([
            'title' => ['required', 'min:3'],
            'salary' => ['required'],
        ]);

        // update job

        $job->update([
            'title' => request('title'),
            'salary' => request('salary'),
        ]);


        // redirect


        return redirect('/jobs/' . $job->id);
    }

    public function destroy(Job $job)
    {
        Gate::authorize('edit-job', $job);


        $job->delete();
        return redirect('/jobs');
    }
}
