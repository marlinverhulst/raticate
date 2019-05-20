<?php

namespace App\Http\Controllers;
use App\User;
use App\Job;
use Illuminate\Http\Request;

class RouteBuilderController extends Controller
{

     //
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
        $userId = User::findOrFail($request->id);
      

        $dates = $userId->jobs()->where([['done','=', 0],['visitdate', '!=', null]])->select('visitdate')->distinct()->orderBy('visitdate')->get();
        
        return response()->json([
            'dates' => $dates
        ],200);
        
    }

    public function getJobs(Request $request)
    {
        //
        $userId = User::findOrFail($request->id);
      

        $jobs = $userId->jobs()->where([['done','=', 0],['visitdate', '=', $request->visitdate]])->orderBy('priority')->get();
        
        return response()->json([
            'jobs' => $jobs
        ],200);
        
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
        $job = Job::findOrFail($id);
        
        $job->update([
         
        
        'priority' => $request->priority,
        ]);
        $job->save();
        
        
                         
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
