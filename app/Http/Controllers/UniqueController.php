<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App;
use File;

class UniqueController extends Controller
{
    //
    public function getAllData(){
      //$events = DB::table('events')->get();
      $fashion = \App\Men::orderBy('id', 'desc')->get();
      //$result = DB::table('tenets')->take(6)->get();
      //$tenets = \App\Tenet::hydrate($result);
      //print_r($fashion);

      return view('unique')->with('data', ['fashion' => $fashion, 'category' => 'All Categories']);
    }

    public function getSingleData($category, $id){
      $fashion = \App\Men::where('ID', $id)->first();
      $author = \App\Author::where('id', $fashion->author)->first();
      DB::table('fashions')->where('ID', $id)->increment('views');
      $recommended = \App\Men::where('id', '!=', $id)->orderBy('views', 'DESC')->take(4)->get();
      //$author = \App\Author::where('id', $fashion->author)->first();
      //print_r($fashion);
      //print_r($id);

      if ($fashion->type == "Article"){
        return view('unique-single')->with('data', ['fashion' => $fashion, 'author' => $author, 'recommended' => $recommended]);
      } else {
        return view('unique-single-video')->with('data', ['fashion' => $fashion, 'author' => $author, 'recommended' => $recommended]);
      }


    }

    public function getCategoryData($category){

        if ($category == "gallery"){

          $directory = "fem/gallery";
          $files = File::allFiles($directory);

          //print_r($files);

          return view('gallery')->with('data', ['files' => $files, 'category' => 'Gallery']);

        } else {

          $this_category = \App\MenCategory::where('slug', $category)->first();
          $fashion = \App\Men::where('category', $this_category->name)->get();


          //print_r($fashion);

          return view('unique')->with('data', ['fashion' => $fashion, 'category' => $this_category->name]);

          }

    }

    public function getGallery(){

        $this_category = \App\MenCategory::where('slug', $category)->first();
        $fashion = \App\Men::where('category', $this_category->name)->get();

        //print_r($fashion);

        return view('gallery')->with('data', ['fashion' => $fashion, 'category' => $this_category->name]);

    }


}
