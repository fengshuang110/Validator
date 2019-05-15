<?php
namespace Validator;

class EmailValidator
{
    public function __construct($rule, $key, $params)
    {
        $value = '94555825@qq.com';

        if(filter_var($value, FILTER_VALIDATE_EMAIL)){
            return true;
        }
        throw  new \Exception("field $key Is Not a Email ");
    }
}
