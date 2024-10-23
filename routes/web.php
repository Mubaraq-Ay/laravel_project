<?php


use App\Models\Job;
use Illuminate\Support\Facades\Route;



// index
Route::get('/', function () {
    return view('home'); 
});
Route::get('/jobs', function () {
    
    $jobs = Job::with('employer')->latest()->simplePaginate(3);

    return view('jobs/index', [
      
        'jobs' => $jobs,
      
    ]);
});

//create
Route::get('/jobs/create', function () {
    return view('jobs/create');
});

//show
Route::get('/jobs/{job}', function (Job $job) {
  
    return view('jobs/show', ['job' => $job]);
    
});

//store
Route::post('/jobs', function () {
    request()->validate([
        'title' => ['required', 'min:3'],
        'salary' => ['required'],
    ]);

    Job::create([
        'title' => request('title'),
       'salary' => request('salary'),
       'employer_id' => 1
       
    ]);

    return redirect('/jobs');
});

//edit
Route::get('/jobs/{job}/edit', function (Job $job) {
   
    return view('jobs.edit', ['job' => $job]);
    
});

 

//update
Route::patch('/jobs/{job}', function (Job $job) {
    // authorization
    
    
    // validate

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
   
});


//destroy
Route::delete('/jobs/{job}', function (Job $job) {
 
    $job->delete();
  return redirect('/jobs');
});


Route::get('/contact', function () {
    return view('contact');
});
