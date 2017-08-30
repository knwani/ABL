<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fashion extends Model
{
    //

    public function urlFriendly(){
      return str_slug($this->title);
    }

    public function categoryFriendly(){
      return str_slug($this->category);
    }
}
