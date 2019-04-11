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
        
        $jobs = Job::getVisitdates();
        
        
        return response()->json([
            'jobs' => $jobs
        ], 200);
    }

        
    
}
