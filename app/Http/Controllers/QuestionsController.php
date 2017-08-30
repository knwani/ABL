<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use DB;
use App;
use Socialite;
use Request;
use Response;
use Session;

class QuestionsController extends Controller
{
    //
    public function getQuestions(){
      //$events = DB::table('events')->get();
      $questions = \App\Question::all();
      //$result = DB::table('tenets')->take(6)->get();
      //$tenets = \App\Tenet::hydrate($result);
      //$tenets = \App\Tenet::take(6)->get();
      //print_r($tenets);

      return view('askkenny')->with('data', ['questions' => $questions]);
    }

    public function saveQuestion(){
      $question = Request::get('the_question');

      $new_question = new \App\Question;
      $new_question['Question'] = $question;
      //$new_question['Date Asked'] = 'CURRENT_TIMESTAMP';
      $new_question->save();

      Session::put('question.id', $new_question->id);

      //print_r($question->ID);
      return Response::json(array('success' => true, 'last_insert_id' => $new_question->id), 200);
    }

   public function redirectFacebook()
   {
       return Socialite::driver('facebook')->redirect();
   }

   public function callbackFacebook()
   {
       // when facebook call us a with token
       try {
         $user = Socialite::driver('facebook')->user();
         //$user->getName();
         //$user->getEmail();
         $question_id = Session::get('question.id');

         DB::table('questions')
            ->where('id', $question_id)
            ->update(['Who' => $user->getName(), 'Email' => $user->getEmail()]);

       } catch (\Exception $e) {

       }

       return redirect('/ask-kenny');

   }


}
