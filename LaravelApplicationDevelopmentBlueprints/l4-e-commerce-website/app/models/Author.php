<?php

class Author extends Eloquent {

  protected $table = 'authors';

  protected $fillable = array(
    'name',
    'surname'
  );
}
