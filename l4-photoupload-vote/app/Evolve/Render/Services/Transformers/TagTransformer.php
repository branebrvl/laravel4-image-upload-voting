<?php namespace Evolve\Render\Services\Transformers;

use Evolve\Common\Services\Transformers\Transformer;

class TagTransformer extends Transformer {

  public function transform(array $tag)
  {
    return [
        'name' => $tag['name'],
        'slug' => $tag['slug'],
      ];
  }
}
