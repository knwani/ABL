<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App;

class AboutController extends Controller
{

    public function getAuthors(){

      $authors = \App\Author::where('description','!=','')->get();

      return view('about')->with('data', ['authors' => $authors]);
    }


}
