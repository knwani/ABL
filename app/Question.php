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

    public function checkAnswer(){
       $formatted_date = \Carbon\Carbon::parse($this->updated_at);

      if ($this->Answer == ""){
        return "Unanswered";
      } else {
        return "Answered at " . $formatted_date->format('d M Y h:i a');
      }
    }

    public function checkAnswerValue($value){
      if ($value == 'kenny'){
        if ($this->Answer == ""){
          return "Kenny hasn't answered this question yet. Do check back";
        } else {
          return $this->Answer;
        }
      } else if ($value == 'ade'){
        if ($this->ade == ""){
          return "Ade hasn't answered this question yet. Do check back";
        } else {
          return $this->ade;
        }
      } else if ($value == 'sade'){
        if ($this->sade == ""){
          return "Sade hasn't answered this question yet. Do check back";
        } else {
          return $this->sade;
        }
      }

    }

    public function getAvatar(){
      if ($this->auth == "facebook"){
        return $this->avatar . "&width=120&height=120";
      } else {
        return $this->avatar;
      }
    }


}
