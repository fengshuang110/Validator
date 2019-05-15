<?php
require_once 'vendor/autoload.php';

class DemoController
{
    /**
     * @Validator\ParamRules(
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
    public function indexAction()
    {
        return $this->property;
    }
}

\Validator\Bootstrap::init(DemoController::class, 'indexAction');

