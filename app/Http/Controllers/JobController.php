<?php

namespace App\Http\Controllers;

use App\Custom\Support;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $jobs = Job::orderBy('id','desc')->paginate(10);
      return response()->json($jobs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|min:5|max:90',
            'description' => 'required|min:100|max:1000',
            'thumbnail' => 'image',
        ];

        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()){
            return response()->json([
                'errors' => $validation->getMessageBag(),
            ], 402);
        }

        $job = new Job();
        $job->title = $request->title;
        $job->slug = Str::slug($request->title).'-'.rand(111,999);
        $job->description = $request->description;

        if ($request->thumbnail){
            $job->thumbnail = Support::uploadImage($request->thumbnail);
        }

        if ($job->save()){
            return response()->json($job);
        }

        return response()->json(["message" => "Unable to create job. Please try again"], 502);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function show(Job $job)
    {
        return response()->json($job);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Job $job)
    {
        if (!$job){
            return response()->json(['message' => "Job not found"], 404);
        }

        $rules = [
            'title' => 'required|min:5|max:90',
            'description' => 'required|min:100|max:1000',
            'thumbnail' => 'image',
            'status' => 'required',
        ];

        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()){
            return response()->json([
                'errors' => $validation->getMessageBag(),
            ], 402);
        }

        $job->title = $request->title;
        $job->description = $request->description;
        $job->status = $request->status;

        if ($request->thumbnail){
            if ($job->thumbnail){
                Support::deleteFile($job->thumbnail);
            }
            $job->thumbnail = Support::uploadImage($request->thumbnail);
        }

        if ($job->save()){
            return response()->json($job);
        }

        return response()->json(["message" => "Unable to update job. Please try again"], 502);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function destroy(Job $job)
    {
        if ($job->delete()){
        return response()->json(["message" => "Job successfully deleted"], 200);
        }

        return response()->json(["message" => "Unable to delete job. Please try again"], 502);
    }
}
