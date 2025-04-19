<?php
require_once 'interfaces/FunctionStrategy.php';

class MapFunction implements FunctionStrategy {
    public function execute(array $parameters, Interpreter $interpreter) {
        if (count($parameters) !== 2) {
            throw new Exception("map requires two parameters");
        }
        $keys = $interpreter->execute($parameters[0]);
        $values = $interpreter->execute($parameters[1]);
        return array_combine($keys, $values);
    }
}