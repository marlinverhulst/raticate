<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Job;

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

        
    
}
