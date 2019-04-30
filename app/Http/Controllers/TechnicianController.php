<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Job;
use App\Client;
use App\Inspection;
use Carbon\Carbon;


class TechnicianController extends Controller
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

    public function getVisits(){
        
    
        //
        
        $dates = Job::getVisitdates();
        
        
        return response()->json([
            'dates' => $dates
        ], 200);
    }

    public function getJobs(Request $request){
        
    
        //
        $date = $request->visitdate;
        
        return Job::getVisitJobs($date);
       
        
        
        
    }
    
    public function update(Request $request, $id)
    {
        
        if($request->done == 0){

            $request->validate([
                
                'cause' =>'required',
                'visitdate' =>'required'
            ]);

            $parsedDate = Carbon::parse($request->visitdate)->toDateTimeString();

        }

        $job = Job::findOrFail($id);
        
        $job->update([
        
        
        'comments' => $request->comments,
        'callfirst' => $request->callfirst,
        'message' => $request->message,
        'time' => $request->time,
        'cause'=> $request->cause,
        'done' => $request->done,
        'visitdate' => Carbon::parse($request->visitdate)->toDateTimeString()]);

        

        $job->inspections()->create([
            'job_id' => $job->id,
            'date' => "1-1-10",
            'comment' => "testing"
         ]);
        
       
           
        return response()->json([
            'job' => $job]);
        //
    }

        
    
}
