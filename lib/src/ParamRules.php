<?php
namespace Validator;

/**
 * @Annotation
 */
class ParamRules
{
    public function __construct($params)
    {
        try{
            $this->params = $params;
            $this->verifyParamsByRules($this->params);
            return true;
        }catch (\Exception $e){
            echo $e->getMessage();
            return false;
        }
    }
    public function verifyParamsByRules(array $paramRules)
    {
        $needValidationParamRules = [];
        $requiredOneOf = [];
        foreach ($paramRules as $param => $rule) {
            if (isset($rule['required']) && $rule['required'] === true) {
                if (!$this->hasParam($param)) {
                    throw new \Exception('10002');
                }
            }

            if (isset($rule['required_together_with']) && is_array($rule['required_together_with'])) {
                if ($this->hasParam($param)) {
                    foreach ($rule['required_together_with'] as $requiredTogetherWithParam) {
                        if (!$this->hasParam($requiredTogetherWithParam)) {
                            throw new \Exception('10002');
                        }
                    }
                }
            }

            if (isset($rule['mutually_exclusive_with']) && is_array($rule['mutually_exclusive_with'])) {
                if ($this->hasParam($param)) {
                    foreach ($rule['mutually_exclusive_with'] as $mutuallyExclusiveWithParam) {
                        if ($this->hasParam($mutuallyExclusiveWithParam)) {
                            throw new \Exception('10002');
                        }
                    }
                }
            }

            if (isset($rule['required_one_of']) && $rule['required_one_of'] === true) {
                $requiredOneOf[] = $this->hasParam($param);
            }

            if (isset($rule['default'])) {
                $_REQUEST[$param] = $_REQUEST[$param] ?? $rule['default'];
            }

            if ($this->hasParam($param)) {
                $needValidationParamRules[$param] = $rule;
            }
        }

        if (count($requiredOneOf) != 0 && count(array_filter($requiredOneOf)) == 0) {
            throw new \Exception('10002');
        }

        if (!empty($needValidationParamRules)) {
            foreach ($needValidationParamRules as $param => $rule){
                $className = 'Validator\\' . ucfirst($rule['type']) . 'Validator';
                new $className($rule, $param, []);
            }
        }
    }

    private function hasParam($param)
    {
        return true;
        return $this->request->has($param) || isset($_FILES[$param]);
    }

    public static function test()
    {
        echo 1;die;
    }
}