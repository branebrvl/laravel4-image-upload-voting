<?php namespace Acme\Transformers;

class TagTransformer extends Transformer {

  public function transform(array $tag)
  {
    return [
        'name' => $tag['name'],
      ];
  }
}
