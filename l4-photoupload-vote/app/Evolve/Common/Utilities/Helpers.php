<?php namespace Evolve\Common\Utilities;

class Helpers {

  public function wordLimit($string, $limit = 50)  // truncates the string
  {     
    return implode('', array_slice(preg_split('/([\s,\.;\?\!]+)/', $string, $limit*2+1, PREG_SPLIT_DELIM_CAPTURE),0,$limit*2-1));
  }  

  public function getPublicPath()
  {
    return public_path();
  }

  public function getRandomName()
  {
    return sha1(time() . time()); 
  }
}
