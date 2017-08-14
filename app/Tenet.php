<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tenet extends Model
{
    //
    public function urlFriendly(){
      return str_slug($this->article_name);
    }

    public function tenetFriendly(){
      return str_slug($this->category);
    }
}
