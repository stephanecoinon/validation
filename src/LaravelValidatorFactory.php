<?php namespace Coinon\Validation;

use Illuminate\Validation\Factory;

class LaravelValidatorFactory implements FactoryInterface {

    /**
     * @var \Illuminate\Validation\Factory
     */
    private $factory;

    /**
     * @param Factory $factory
     */
    function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Initialize validation
     *
     * @param array $data
     * @param array $rules
     * @param array $messages
     * @return \Illuminate\Validation\Validator
     */
    public function make(array $data, array $rules, array $messages = array(), array $customAttributes = array())
    {
        return $this->factory->make($data, $rules, $messages, $customAttributes);
    }

}
