<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\VisitDate;

class Job extends Model
{
    //
    protected $fillable = [
        'address',
        'zip',
        'city',
        'tel',
        'client_id',
        'pricetag_id',
        'user_id',
        'description',
        'comments',
        'callfirst',
        'message',
        'time',
        'done',
        'visitdate',
        'cause'


    ];

    public function client(){
        return $this->belongsTo('App\Client');
    }
    public function pricetag(){
        return $this->belongsTo('App\PriceTag');

    }
    public function user(){
        return $this->belongsTo('App\User');
    }

    
    

    public function inspections(){
        return $this->hasMany('App\Inspection');
    }
    
    public static function getVisitdates(){
        $userId = Auth::user();

      

        $dates = $userId->jobs()->where([['done','=', 0],['visitdate', '!=', null]])->select('visitdate')->distinct()->get();
        
        return $dates;
    }

    public static function getVisitJobs($date){

        $userId = Auth::user();
        

        $jobs = $userId->jobs()->where([['done','=', 0],['visitdate', '=', $date]])->orderBy('zip')->with('inspections')->get();
        
        return response()->json([
            'jobs' => $jobs,
            
        ], 200);



    }

    
}
