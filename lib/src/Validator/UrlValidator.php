<?php
namespace Validator;

class UrlValidator
{
    public function __construct($rule, $key, $params)
    {
        $value = 'http://www.baidu.com';

        if(filter_var($value, FILTER_VALIDATE_URL)){
            return true;
        }
        throw  new \Exception("field $key Is Not a Url ");
    }
}
