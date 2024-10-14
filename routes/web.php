<?php


use App\Models\Job;
use Illuminate\Support\Facades\Route;



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

Route::get('/jobs/{id}', function ($id) {


    $job = Job::find($id);{
       
   
    return view('jobs/show', ['job' => $job]);
    }
});

//edit
Route::get('/jobs/{id}/edit', function ($id) {
    $job = Job::find($id);{
       
   
    return view('jobs/edit', ['job' => $job]);
    }
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
       
    ]);

    return redirect('/jobs');
});

//update
Route::patch('/jobs/{id}', function ($id) {
    
    $job = Job::findOrFail($id);
    $job->update([
        'title' => request('title'),
       'salary' => request('salary'),
    ]);

    return redirect('/jobs/' . $job->id);
   
});


//destroy
Route::delete('/jobs/{id}', function ($id) {
  Job::findOrFail($id)->delete();


  return redirect('/jobs');
});


Route::get('/contact', function () {
    return view('contact');
});
