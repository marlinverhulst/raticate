<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Job;
use App\Client;
use Carbon\Carbon;

class ReportController extends Controller
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


    public function generateByClient(Request $request)
    {
        //
        $status = $request->status;
        $client_id = $request->client_id;
        $startDate = substr($request->startDate, 0,10);
        $endDate = substr($request->endDate, 0,10);
        $jobs = null;
        
        
        if($client_id != 0 && $status != 2){
            
            $jobs = Job::where([['done', '=', $status],['client_id','=' ,$client_id]])->whereBetween('created_at', array($startDate, $endDate))->with(['client', 'pricetag', 'inspections'])->get();
            return response()->json([
                'jobs' => $jobs
            ], 200);
        }
        if($client_id == 0 && $status != 2){

            $jobs = Job::where('done', $status)->whereBetween('created_at', array($startDate, $endDate))->with(['client', 'pricetag', 'inspections'])->get();
            return response()->json([
                'jobs' => $jobs
            ], 200);
        }
        if($client_id == 0 && $status == 2){

            $jobs = Job::whereBetween('created_at', array($startDate, $endDate))->with(['client', 'pricetag', 'inspections'])->get();
            return response()->json([
                'jobs' => $jobs
            ], 200);
        }

        if($client_id != 0 && $status == 2){

            $jobs = Job::where([['client_id','=' ,$client_id]])->whereBetween('created_at', array($startDate, $endDate))->with(['client', 'pricetag', 'inspections'])->get();
            return response()->json([
                'jobs' => $jobs
            ], 200);
        }
        

       
        
        
        
    }






}
