<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Men extends Model
{
    //
    public function urlFriendly(){
      return str_slug($this->title);
    }

    public function categoryFriendly(){
      return str_slug($this->category);
    }

    public function getBody(){
      $src = $this->body;
      $src = str_replace("http://localhost:8080/", "http://abeautifullifebykenny.com/", $src);

      return $src;
    }
}
