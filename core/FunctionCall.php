<?php
require_once 'Expression.php';

class FunctionCall extends Expression {
    private string $_functionName;
    private array $_parameters;

    public function __construct(string $functionName, array $parameters = []) {
        $this->setFunctionName($functionName);
        $this->setParameters($parameters);      // Инициализируем параметры
    }

    public function getFunctionName(): string {
        return $this->_functionName;
    }

    public function getParameters(): array {
        return $this->_parameters;
    }

    public function setFunctionName(string $functionName) {
    	$this->_functionName = $functionName;
    }

    public function setParameters(array $parameters) {
    	$this->_parameters = $parameters;
    }
}