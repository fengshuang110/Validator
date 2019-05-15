<?php
namespace Validator;

class DatetimeValidator
{
    public function __construct($rule, $attribute, $params)
    {
//        $datetime = $params[$attribute];
        $datetime = "2019-12-13 12:11:11";
        if(empty($rule['format'])){
            throw new \Exception("datetime is not format");
        }

        if (!$this->validateDateTime($datetime, $rule['format'])) {
            throw new \Exception('Datetime format error');
        }
        return true;
    }
    private function validateDateTime($datetime, $format)
    {
        return date($format, strtotime($datetime)) === $datetime;
    }
}
