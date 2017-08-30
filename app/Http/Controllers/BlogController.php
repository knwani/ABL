<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App;

class BlogController extends Controller
{
    //
    public function getSingleBlog($id, $title){
      //$events = DB::table('events')->get();
      //$result = DB::table('tenets')->take(6)->get();
      //$tenets = \App\Tenet::hydrate($result);
      $blog = \App\Blog::where('id', $id)->first();
      //$author = \App\Author::where('id', $blog->author)->first();
      DB::table('blogs')->where('ID', $id)->increment('views');
      $recommended = \App\Blog::where('id', '!=', $id)->orderBy('views', 'DESC')->take(1)->get();
      //$recommended = \App\Tenet::where('id', '!=', $id)->where('category', $tenet->category)->orderBy('views', 'DESC')->take(8)->get();
      //print_r($tenet->id);
      //print_r($author);
      //print_r($tenet);
      return view('blog-single')->with('data', ['recommended' => $recommended, 'blog' => $blog]);
    }

    public function getBlogs(){

      $blog = \App\Blog::all();

      return view('blog')->with('data', ['blog' => $blog]);
    }


}
