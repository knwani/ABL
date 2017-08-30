<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App;

class FemController extends Controller
{
    //
    public function getAllData(){
      //$events = DB::table('events')->get();
      $fashion = \App\Fashion::all();
      //$result = DB::table('tenets')->take(6)->get();
      //$tenets = \App\Tenet::hydrate($result);
      //print_r($fashion);

      return view('feminique')->with('data', ['fashion' => $fashion, 'category' => 'All Categories']);
    }

    public function getSingleData($category, $id){
      $fashion = \App\Fashion::where('ID', $id)->first();
      DB::table('fashions')->where('ID', $id)->increment('views');
      $recommended = \App\Fashion::where('id', '!=', $id)->orderBy('views', 'DESC')->take(4)->get();
      //$author = \App\Author::where('id', $fashion->author)->first();
      //print_r($fashion);
      //print_r($id);

      return view('feminique-single')->with('data', ['fashion' => $fashion, 'recommended' => $recommended]);
    }

    public function getCategoryData($category){

        $this_category = \App\FashionCategory::where('slug', $category)->first();
        $fashion = \App\Fashion::where('category', $this_category->name)->get();

        //print_r($fashion);

        return view('feminique')->with('data', ['fashion' => $fashion, 'category' => $this_category->name]);

    }


}
