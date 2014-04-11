<?php namespace Evolve\Common\Validation;

use Illuminate\Validation\Factory;

abstract class AbstractValidator implements ValidationInterface
{
  /**
   * Illuminate validation factory which we utilise
   *
   * @var Illuminate\Validation\Factory
   */
  protected $factory;

  /**
   * The data under test
   *
   * @var array
   */
  protected $data = [];

  /**
   * The rules to be used to validate the data
   *
   * @var array
   */
  protected $rules = [];

  /**
   * If there are any errors, they will be here
   *
   * @var array
   */
  protected $errors = [];

  /**
   * Any custom validation messages, useful
   * for `model.id` type messages
   *
   * @var array
   */
  protected $messages = [];

  public function __construct(Factory $factory)
  {
     $this->factory = $factory;
  }

  final public function rules(array $rules)
  {
    $this->rules = $rules;

    return $this;
  }

  /**
   * Set the data under test
   *
   * @param  array  $data
   * @return Evolve\Common\Validation\ValidationInterface
   */
  public function with(array $data)
  {
    $this->data = $data;

    return $this;
  }

  /**
   * Return the errors if any
   *
   * @return array
   */
  final public function errors()
  {
    return $this->errors;
  }

  /**
   * Get the prepared validation rules.
   *
   * @return array
   */
  protected function getPreparedRules()
  {
    return $this->rules;
  }

  /**
   * Actually validate the data based on given rules
   *
   * @return bool
   */
  public function passes()
  {
    $validation = $this->factory
                        ->make(
                          $this->data,
                          $this->getPreparedRules(),
                          $this->messages
                        );

    if ($validation->fails())
    {
      $this->errors = $validation->messages();
      return false;
    }

    return true;
  }

  /**
   * Returns the inverse validation result
   *
   * @return bool
   */
  final public function fails()
  {
    return ! $this->passes();
  }
}
