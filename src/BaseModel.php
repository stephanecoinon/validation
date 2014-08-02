<?php namespace Coinon\Validation;

use Illuminate\Database\Eloquent\Model as Eloquent;


class BaseModel extends Eloquent {

    /**
     * The validator factory instance.
     *
     * @var Coinon\Validation\ValidatorInterface
     */
    protected static $validatorFactory = null;

    /**
     * The validation rules.
     *
     * @var array
     */
	public static $rules = [];

    /**
     * The validation error message templates.
     *
     * @var array
     */
	public static $errorMessages = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [];

    /**
     * The errors generated by validation.
     *
     * @var array
     */
    protected $errors = [];


    /**
     * Create a new BaseModel instance
     *
     * @param array $attributes
     * @return void
     */
    public function __construct(array $attributes = [ ])
    {
        // @TODO Use Input::only($fields) if $attributes is empty
        // List fields having a validation rule
        $fields = array_keys(static::$rules);

        // Make the fields fillable
        $this->fillable = $fields;

        // Keep only attributes which have a validation rule
        $validatedAttributes = [];
        foreach ($attributes as $field => $value) {
            if (in_array($field, $fields)) {
                $validatedAttributes[$field] = $value;
            }
        }
        $this->fill($validatedAttributes);
    }

    /**
     * Inject the validator factory.
     *
     * @param Coinon\Validation\FactoryInterface $validator validator instance
     * @return void
     */
    public static function setValidatorFactory(FactoryInterface $validatorFactory)
    {
        static::$validatorFactory = $validatorFactory;
    }

    /**
     * Return result of data validation.
     *
     * @return boolean
     * @throws Exception if the validator instance wasn't injected
     */
    public function validate()
    {
        if (is_null(static::$validatorFactory)) {
            throw new \Exception('Validator factory instance not set.');
        }

        $v = static::$validatorFactory->make($this->toArray(), static::$rules, static::$errorMessages);

        if ($v->fails())
        {
            $this->errors = $v->errors();
            return false;
        }

        // validation pass
        return true;
    }

    /**
     * Return validation errors.
     *
     * @return array
     */
    public function errors()
    {
        return $this->errors;
    }

}