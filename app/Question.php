<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //
    public $timestamps = false;

    public function titleFriendly(){
      return str_slug($this->Question);
    }

}
