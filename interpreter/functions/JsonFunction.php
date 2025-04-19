<?php
require_once 'interfaces/FunctionStrategy.php';

class JsonFunction implements FunctionStrategy {
    public function execute(array $parameters, Interpreter $interpreter) {
        return json_encode($interpreter->execute($parameters[0], $args));
    }
}