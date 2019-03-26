<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
        'visit'


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
    

    
}
