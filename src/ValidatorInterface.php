<?php namespace Coinon\Validation;

interface ValidatorInterface {

    /**
     * Determine if the data fails the validation rules.
     *
     * @return bool
     */
    public function fails();

    /**
     * Get the list of validation errors.
     *
     * @return mixed
     */
    public function errors();

}
