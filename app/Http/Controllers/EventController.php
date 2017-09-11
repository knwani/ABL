<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class EventController extends Controller
{
    //
    public function getEventData($id){
      //$event = DB::table('events')->where('id', $id)->get();
      $event = \App\Event::where('ID', $id)->first();

      //print_r($event);
      return view('event')->with('data', ['event' => $event]);
    }
}
