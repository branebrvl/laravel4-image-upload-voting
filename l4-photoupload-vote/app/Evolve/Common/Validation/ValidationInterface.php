<?php namespace Evolve\Common\Validation;

interface ValidationInterface
{
  /**
   * We can set rules on the fly
   *
   * @param  array  $rules
   * @return Evolve\Common\Validation\ValidationInterface
   */
  public function rules(array $rules);

  /**
   * Collect the data under validation. It
   * should return itself to enable chaining
   *
   * @param  array $data The data under test
   * @return Evolve\Common\Validation\ValidationInterface
   */
  public function with(array $data);

  /**
   * Returns the errors array
   *
   * @return array
   */
  public function errors();


  /**
   * Should instanciate the validator, and
   * validate the data under test.
   *
   * @return bool
   */
  public function passes();

  /**
   * The same as passes but returns the inverse.
   *
   * @return bool
   */
  public function fails();
}
