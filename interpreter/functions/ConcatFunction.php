<?php
require_once 'interfaces/FunctionStrategy.php';

class ConcatFunction implements FunctionStrategy {
    public function execute(array $parameters, Interpreter $interpreter) {
        if (count($parameters) !== 2) {
            throw new Exception("concat requires two parameters");
        }
        return $interpreter->execute($parameters[0]) . $interpreter->execute($parameters[1]);
    }
}