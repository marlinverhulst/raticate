<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inspection extends Model
{
    //
    protected $fillable = [
        'job_id',
        'date',
        'comment'
        

    ];

    public function job(){
        return $this->belongsTo('App\Job');
    }
}
