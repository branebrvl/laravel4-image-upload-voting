<?php

class Cart extends Eloquent {

  protected $table = 'carts';

  protected $fillable = array(
    'member_id',
    'book_id',
    'amout',
    'total'
  );

  public function Books()
  {
    return $this->belongsTo('Book', 'book_id');
  }

}
