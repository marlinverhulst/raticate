<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Job;
use App\Client;

class JobsController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $status = $request->status;
        $jobs = Job::with(['client', 'pricetag', 'user'])->where('done',$status)->get();
        
        
        return response()->json([
            'jobs' => $jobs
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'address' =>'required',
            'client_id' => 'required',
            'pricetag_id' => 'required',
            'user_id' => 'required',
            'city' =>'required',
            ]);


            $job = Job::create([
                'address' => $request->address,
                'zip' => $request->zip,
                'city' => $request->city,
                'tel' => $request->tel,
                'client_id' => $request->client_id,
                'pricetag_id' => $request->pricetag_id,
                'user_id' => $request->user_id,
                'description' => $request->description,
                'comments' => $request->comments,
                'callfirst' => $request->callfirst,
                'message' => $request->message,
                'time' => $request->time,
                'done' => $request->done,
                
                
            ]);
    
            return response()->json([
                'job' => $job,
                'message' => 'job created'
            ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
