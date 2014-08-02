<?php

use Coinon\Validation\BaseModel;

class Book extends BaseModel {

    public static $rules = [
        'title'  => 'required',
        'author' => 'required',
    ];

}
