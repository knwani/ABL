<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App;
use File;

class FemController extends Controller
{
    //
    public function getAllData(){
      //$events = DB::table('events')->get();
      $fashion = \App\Fashion::orderBy('id', 'desc')->get();
      //$result = DB::table('tenets')->take(6)->get();
      //$tenets = \App\Tenet::hydrate($result);
      //print_r($fashion);

      return view('feminique')->with('data', ['fashion' => $fashion, 'category' => 'All Categories']);
    }

    public function getSingleData($category, $id){
      $fashion = \App\Fashion::where('ID', $id)->first();
      $author = \App\Author::where('id', $fashion->author)->first();
      DB::table('fashions')->where('ID', $id)->increment('views');
      $recommended = \App\Fashion::where('id', '!=', $id)->orderBy('views', 'DESC')->take(4)->get();
      //$author = \App\Author::where('id', $fashion->author)->first();
      //print_r($fashion);
      //print_r($id);

      return view('feminique-single')->with('data', ['fashion' => $fashion, 'author' => $author, 'recommended' => $recommended]);
    }

    public function getGalleryLink(){

      $gallery = \App\Gallery::orderBy('id', 'desc')->get();

      return view('gallery')->with('data', ['files' => $gallery]);

    }

    public function getSingleGallery($folder){
      $directory = "fem/gallery/" . $folder;
      $files = File::allFiles($directory);

      //print_r($files);
      return view('gallery-single')->with('data', ['files' => $files]);
    }

    public function getCategoryData($category){

        //if ($category == "gallery"){



        //} else {

          $this_category = \App\FashionCategory::where('slug', $category)->first();
          $fashion = \App\Fashion::where('category', $this_category->name)->get();

          //print_r($fashion);

          return view('feminique')->with('data', ['fashion' => $fashion, 'category' => $this_category->name]);

          //}

    }

    public function getGallery(){

        $this_category = \App\FashionCategory::where('slug', $category)->first();
        $fashion = \App\Fashion::where('category', $this_category->name)->get();

        //print_r($fashion);

        return view('gallery')->with('data', ['fashion' => $fashion, 'category' => $this_category->name]);

    }


}
