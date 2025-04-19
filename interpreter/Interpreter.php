<?php
require_once 'core/Constant.php';
require_once 'core/FunctionCall.php';
require_once 'functions/ArrayFunction.php';
require_once 'functions/ConcatFunction.php';
require_once 'functions/GetArgFunction.php';
require_once 'functions/JsonFunction.php';
require_once 'functions/MapFunction.php';
require_once 'exceptions/interpreter/InterpreterException.php';

class Interpreter {
    private $_appArgs = [];
    private $functionStrategies = [];
    
    public function __construct() {
        $this->functionStrategies = [
            'getArg' => new GetArgFunction(),
            'array' => new ArrayFunction(),
            'map' => new MapFunction(),
            'json' => new JsonFunction(),
            'concat' => new ConcatFunction(),
        ];
    }

    public function getAppArgs() : array {
        return $this->_appArgs;
    }

    public function setAppArgs(array $appArgs) {
        $this->_appArgs = $appArgs;
    }

    public function execute($expression, $args = []) {
    	if (empty($this->getAppArgs())) {
    		$this->setAppArgs($args);	
    	}
    	
        if ($expression instanceof Constant) {
            return $this->handleConstant($expression);
        } elseif ($expression instanceof FunctionCall) {
            return $this->handleFunctionCall($expression, $args);
        }
        throw new InterpreterException("Unknown expression type");
    }

    private function handleConstant($constant) {
        return $constant->getValue();
    }

    private function handleFunctionCall($functionCall) {
        $functionName = $functionCall->getFunctionName();
        if (isset($this->functionStrategies[$functionName])) {
            return $this->functionStrategies[$functionName]->execute($functionCall->getParameters(), $this);
        }
        return $this->callUserFunction($functionCall);
    }
}