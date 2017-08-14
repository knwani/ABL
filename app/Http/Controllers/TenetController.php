<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App;

class TenetController extends Controller
{
    //
    public function getTenetData($id){
      //$events = DB::table('events')->get();
      //$result = DB::table('tenets')->take(6)->get();
      //$tenets = \App\Tenet::hydrate($result);

      $tenet = \App\Tenet::where('id', $id)->first();
      $author = \App\Author::where('id', $tenet->author)->first();
      $recommended = \App\Tenet::where('id', '!=', $id)->where('category', $tenet->category)->orderBy('views', 'DESC')->take(8)->get();
      //print_r($tenet->id);
      //print_r($author);
      //print_r($tenet);
      return view('tenet')->with('data', ['recommended' => $recommended, 'tenet' => $tenet, 'author' => $author]);
    }


}
