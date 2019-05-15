<?php
namespace Validator;

class ArrayValidator
{
    public function __construct($rule, $key, $params)
    {
        $arrayParam = [1,2,'asasas'];
        $this->min = isset($rule['min']) ? $rule['min'] : PHP_INT_MIN;
        $this->max = isset($rule['max']) ? $rule['max'] : PHP_INT_MAX;

        if (!is_array($arrayParam)) {
            throw new \Exception("Array field $key Is Not Array ");
        }
        if (count($arrayParam) < $this->min) {
            throw new \Exception("Array field $key Min Length is ".$this->min);
        }
        if (count($arrayParam) > $this->max) {
            throw new \Exception("Array field $key Max Length is ".$this->max);
        }
        if(isset($rule['length'])){
            foreach ($arrayParam as $value){
                if (is_string($value) && mb_strlen($value) > $rule['length']) {
                    throw new \Exception("Array field $key  value size is too large");
                }
            }
        }

    }
}
