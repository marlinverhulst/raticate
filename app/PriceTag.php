<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PriceTag extends Model
{
    //
    protected $fillable = [
        'name',
        'kind',
        'cost',
         'client_id'
    ];

    public function client(){
        return $this->belongsTo('App\Client');
    }

}
