<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class EventController extends Controller
{
    //
    public function getEventData(){
      $events = DB::table('events')->get();
      return view('home')->with('data', $events);
    }
}
