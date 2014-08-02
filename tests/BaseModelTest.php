<?php

use \Mockery as m;

use Coinon\Validation\BaseModel;
use Coinon\Validation\FactoryInterface;
use Coinon\Validation\ValidatorInterface;


class BaseModelTest extends PHPUnit_Framework_TestCase {

    /**
     * Validator mock instance.
     *
     * @var Coinon\Validation\ValidatorInterface
     */
    protected $validator;


    public function setUp()
    {
        $this->validatorFactory = m::mock('Coinon\Validation\FactoryInterface');
        BaseModel::setValidatorFactory($this->validatorFactory);
    }

    /**
     * @test
     */
    public function it_is_initializable()
    {
        $model = new BaseModel;

        $this->assertInstanceOf('Coinon\Validation\BaseModel', $model);
    }

    /**
     * @test
     */
    public function it_makes_validated_fields_fillable()
    {
        $model = new Book;

        $this->assertSame(['title', 'author'], $model->fillable);
    }

    /**
     * @test
     */
    public function it_fills_model_with_given_fields_having_a_validation_rule()
    {
        $bookFields = [
            'title'  => 'Gone with the wind',
            'author' => 'Margaret Mitchell',
        ];
        $book = new Book($bookFields);

        $this->assertSame($bookFields, $book->toArray());
    }

    /**
     * @test
     */
    public function it_does_not_fill_fields_without_a_validation_rule()
    {
        $book = new Book([
            'price'  => 5.99,
        ]);
        $this->assertObjectNotHasAttribute('price', $book);
    }

    /**
     * @test
     */
    public function it_passes_validation()
    {
        $validator = m::mock(ValidatorInterface::class);
        $validator->shouldReceive('fails')->once()->andReturn(false);
        $validator->shouldReceive('errors')->never();
        $this->validatorFactory
            ->shouldReceive('make')->once()
            ->andReturn($validator);

        $book = new Book;

        $validates = $book->validate();

        $this->assertTrue($validates);
        $this->assertEmpty($book->errors());

    }

    /**
     * @test
     */
    public function it_returns_errors_on_failed_validation()
    {
        $errors = ['attribute' => 'Attribute is missing'];
        $validator = m::mock(ValidatorInterface::class);
        $validator->shouldReceive('fails')->once()->andReturn(true);
        $validator->shouldReceive('errors')->once()->andReturn($errors);
        $this->validatorFactory
            ->shouldReceive('make')->once()
            ->andReturn($validator);

        $book = new Book;

        $validates = $book->validate();

        $this->assertFalse($validates);
        $this->assertSame($errors, $book->errors());

    }

}
