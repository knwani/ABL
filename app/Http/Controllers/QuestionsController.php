<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use DB;
use App;
use Socialite;
use Request;

class QuestionsController extends Controller
{
    //
    public function getQuestions(){
      //$events = DB::table('events')->get();
      $questions = \App\Question::all();
      //$result = DB::table('tenets')->take(6)->get();
      //$tenets = \App\Tenet::hydrate($result);
      $tenets = \App\Tenet::take(6)->get();
      //print_r($tenets);

      return view('askkenny')->with('data', ['questions' => $questions]);
    }

    public function saveQuestion(){
      $question = Request::get('the_question');

      $new_question = new \App\Question;
      $new_question['Question'] = $question;
      $new_question['Date Asked'] = 'CURRENT_TIMESTAMP';
      $new_question->save();

      print_r($question);
    }

   public function redirectFacebook()
   {
       return Socialite::driver('facebook')->redirect();
   }

   public function callbackFacebook()
   {
       // when facebook call us a with token
   }


}
