<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //
    public function urlFriendly(){
      return str_slug($this->event_name);
    }
}
