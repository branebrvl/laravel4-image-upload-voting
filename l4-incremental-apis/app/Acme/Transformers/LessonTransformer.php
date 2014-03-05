<?php namespace Acme\Transformers;

class LessonTransformer extends Transformer {

  public function transform(array $lesson)
  {
    return [
        'title' => $lesson['title'],
        'body' => $lesson['body'],
        'active' => (boolean) $lesson['some_bool']
      ];
  }
}
