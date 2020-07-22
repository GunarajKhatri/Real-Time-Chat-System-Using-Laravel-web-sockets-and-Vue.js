<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Chat;
use Illuminate\Support\Facades\Auth;
use App\Events\ChartEvent;
class ChatController extends Controller
{		
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function homepage()
    {
        return view('chat');
    }

    public function send(Request $request){
    	$msg=auth()->user()->message()->create([
    			'message'=>$request->message
    	]);
    	broadcast(new ChartEvent($msg->load('user')))->toOthers();
    	return $msg;
    }
    
    public function fetchmessage(){
    	$msg=Chat::with('user')->get();
    	return $msg;
    }
}
