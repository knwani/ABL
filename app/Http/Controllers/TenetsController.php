<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App;

class TenetsController extends Controller
{
    //
    public function getTenets($tenet){
      //$events = DB::table('events')->get();
      //$result = DB::table('tenets')->take(6)->get();
      //$tenets = \App\Tenet::hydrate($result);

      //$tenet = \App\Tenet::where('id', $id)->first();
      $category = \App\Category::where('slug', $tenet)->first();
      $tenets = \App\Tenet::where('category', $category->name)->get();
      //print_r($tenet->id);
      //print_r($author);

      //print_r($category);
      //print_r($tenet);
      return view('tenets')->with('data', ['tenets' => $tenets, 'category' => $category]);
    }


}
