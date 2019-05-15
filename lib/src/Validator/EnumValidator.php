<?php
namespace Validator;

class EnumValidator
{
    public function __construct($rule,$key, $params)
    {
        if (empty($rule['domain'])){
            throw new \Exception("Enum field $key empty domain");
        }
        $value = 1;
        $rule['domain'] = explode(',',$rule['domain']);
        if(in_array($value , $rule['domain'])){
            return true;
        }
        throw new \Exception("Enum field $key Not In ".json_encode($rule['domain']));
    }
}
