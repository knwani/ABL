<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App;
use File;

class Gallery extends Model
{
    //
    protected $table = 'gallery';


    public function getFolder(){
      $title = $this->Name;
      $date_value = $this['Event Date'];

      $folder = str_replace(" ", "_", $title) . "_" . str_replace(" ", "_", $date_value);

      $folder = strtolower($folder);

      return $folder;
    }

    public function getFirstImage(){
      $directory = "fem/gallery/";
      $folder = $this->getFolder();

      $folder = $directory . $folder;

      $files = File::allFiles($folder);

      $file = $files[0];

      return $file;
    }
}
