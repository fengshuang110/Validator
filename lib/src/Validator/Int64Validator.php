<?php
namespace Validator;

class Int64Validator
{
    private $min;
    private $max;
    public function __construct($rule,$key, $params)
    {
        $this->min = isset($rule['min']) ? $rule['min'] : PHP_INT_MIN;
        $this->max = isset($rule['max']) ? $rule['max'] : PHP_INT_MAX;

        $value = isset($params[$key]) ? $params[$key] : 1010;
        
        $options = [
            'options' => [
                'min_range' => $this->min,
                'max_range' => $this->max
            ]
        ];
        if(filter_var($value, FILTER_VALIDATE_INT, $options)){
            return true;
        }

        throw new \Exception("value min :".$this->min . ' max :'.$this->max);
    }
}
