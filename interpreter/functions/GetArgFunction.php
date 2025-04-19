<?php
require_once 'interfaces/FunctionStrategy.php';

class GetArgFunction implements FunctionStrategy {
    public function execute(array $parameters, Interpreter $interpreter) {
        if (isset($parameters[0]) && is_numeric($parameters[0]->getValue())) {
            return $interpreter->getAppArgs()[$parameters[0]->getValue()] ?? null;
        }
        throw new Exception("Invalid argument index");
    }
}