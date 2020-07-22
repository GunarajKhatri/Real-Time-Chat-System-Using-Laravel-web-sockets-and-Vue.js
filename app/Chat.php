<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Chat extends Model
{
    public function user(){
    	return $this->belongsTo(User::class);
    }
    protected $fillable = [
        'message', 
    ];
    public function getCreatedAtAttribute($date){
    	return Carbon::parse($date)->format('d-M-Y H:i:s');
    }
}
