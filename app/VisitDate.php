<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VisitDate extends Model
{
    //
    protected $fillable = [
        'job_id',
        'date'

    ];


    public function job(){

        return $this->belongesTo('App\Job');
    }
}
