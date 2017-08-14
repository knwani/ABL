<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App;

class HomeController extends Controller
{
    //
    public function getAllData(){
      //$events = DB::table('events')->get();
      $events = \App\Event::all();
      //$result = DB::table('tenets')->take(6)->get();
      //$tenets = \App\Tenet::hydrate($result);
      $tenets = \App\Tenet::take(6)->get();

      //print_r($tenets);

      return view('home')->with('data', ['events' => $events, 'tenets' => $tenets]);
    }


}
