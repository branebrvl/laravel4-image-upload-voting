<?php namespace Evolve\Render\Services\Transformers;

use Evolve\Common\Services\Transformers\Transformer;

class RenderTransformer extends Transformer {

  public function transform(array $render)
  {
    return [
        'title' => $render['title'],
        'slug' => $render['slug'],
        'description' => $render['description'],
        'img_min' => $render['img_min'],
        'img_big' => $render['img_big'],
        'show' => (boolean) $render['show']
      ];
  }
}
