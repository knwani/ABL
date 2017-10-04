<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use DB;
use App;
use Request;
use Response;

class HomeController extends Controller
{
    //
    public function getAllData(){
      //$events = DB::table('events')->get();
      $events = \App\Event::all();
      //$result = DB::table('tenets')->take(6)->get();
      //$tenets = \App\Tenet::hydrate($result);
      $tenets = \App\Tenet::take(6)->orderBy('id', 'desc')->get();

      //print_r($tenets);

      return view('home')->with('data', ['events' => $events, 'tenets' => $tenets]);
    }

    public function saveSignUp(){
      $name = Request::get('the_name');
      $email = Request::get('the_email');
      $number = Request::get('the_number');

      $new_question = new \App\Newsletter;
      $new_question['name'] = $name;
      $new_question['number'] = $number;
      $new_question['email'] = $email;
      //$new_question['Date Asked'] = 'CURRENT_TIMESTAMP';
      $new_question->save();

      return Response::json(array('success' => true, 'last_insert_id' => $new_question->id), 200);
    }


}
