<?php namespace Coinon\Validation;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;


class ValidationServiceProvider extends ServiceProvider {

    protected $defer = false;

    public function register() { }

    public function boot()
    {
        $this->package('stephanecoinon/validation');
        AliasLoader::getInstance()->alias('BaseModel', 'Coinon\Validation\BaseModel');
        BaseModel::setValidatorFactory(new LaravelValidatorFactory($this->app->make('validator')));
    }

}
