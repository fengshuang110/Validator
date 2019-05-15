<?php
namespace Validator;

class StringValidator
{
    private $min;
    private $max;

    public function __construct($rule, $key, $params)
    {
        $this->min = isset($rule['min']) ? $rule['min'] : PHP_INT_MIN;
        $this->max = isset($rule['max']) ? $rule['max'] : PHP_INT_MAX;

        $value = isset($params[$key]) ? $params[$key] : "11";
        $value = filter_var($value, FILTER_SANITIZE_STRING);

        if(strlen($value) >= $this->min && strlen($value) <= $this->max){
            return true;
        }
        throw new \Exception("field $key min :" . $this->min . ' max :' . $this->max);
    }
}
