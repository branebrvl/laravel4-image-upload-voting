<?php

class AbstractValidatorTest extends TestCase
{
    /**
     * @var Sneek\Validation\AbstractValidator
     */
    protected $validator;

    public function setUp()
    {
        parent::setUp();
        $validationFactory = App::make('Illuminate\Validation\Factory');
        $this->validator = $this->getMockForAbstractClass('Sneek\Validation\AbstractValidator', [$validationFactory]);
    }

    /**
     * @test
     */
    public function it_passes_validation()
    {
        $this->validator->with(['name' => 'Cristian Giordano']);

        $this->assertTrue($this->validator->passes());
        $this->assertFalse($this->validator->fails());
    }

    /**
     * @test
     */
    public function it_fails_validation()
    {
        $this->validator->rules(['name' => 'required'])->with(['name' => '']);

        $this->assertFalse($this->validator->passes());
        $this->assertTrue($this->validator->fails());
    }

}
