<?php namespace Coinon\Validation;

interface FactoryInterface {

    /**
     * Create a new Validator instance.
     *
     * @param  array  $data
     * @param  array  $rules
     * @param  array  $messages
     * @param  array  $customAttributes
     * @return \Coinon\Validation\FactoryInterface
     */
    public function make(array $data, array $rules, array $messages = array(), array $customAttributes = array());

}
