<?php
require_once 'vendor/autoload.php';

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
}

class AnnotationDemo
{
    /**
     * @ParamRules(
     *  int64={"type": "int64", "min": 1000, "max": 9999, "required": true},
     *  string={"type": "string", "min": 1, "max": 200, "required": true},
     *  enum={"type": "enum", "domain":"1,2", "required": true},
     *  url={"type": "url", "required": true},
     *  email={"type": "email", "required": true},
     *  array={"type": "array", "min": 1, "max": 200, "required": true},
     *  datetime={"type": "datetime", "format":"Y-m-d H:i:s", "required": true},
     *  binary={"type": "binary", "required": true},
     *  image={"type": "image", "required": true},
     *  audio={"type": "audio", "required": true},
     * )
     */
    public function getProperty()
    {
        return $this->property;
    }
}
use Doctrine\Common\Annotations\AnnotationReader;

$reader = new AnnotationReader();
$reflectionClass = new ReflectionClass('AnnotationDemo');
$result = $reader->getMethodAnnotations($reflectionClass->getMethod('getProperty'));
var_dump($result);