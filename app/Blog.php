<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    //
    public function authorData(){

      $author = \App\Author::where('id', $this->author)->first();

      return $author;
    }

    public function getBodyPreview(){
      $preview = strip_tags($this->body);
      $count = strlen($preview);

      if ($count > 300){
        $final_preview = str_limit($preview, 250);
      } else {
        $final_preview = str_limit($preview, $count);
      }

      return $final_preview;
    }

    public function titleFriendly(){
      return str_slug($this->title);
    }

    public function getBody(){
      $src = $this->body;
      $src = str_replace("http://localhost:8080/", "http://abeautifullifebykenny.com/", $src);

      return $src;
    }

}
