<?php
require_once 'interfaces/FunctionStrategy.php';

class ArrayFunction implements FunctionStrategy {
    public function execute(array $parameters, Interpreter $interpreter) {
        $result = [];
        foreach ($parameters as $param) {
            $result[] = $interpreter->execute($param);
        }
        return $result;
    }
}