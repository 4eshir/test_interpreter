<?php

interface FunctionStrategy {
    public function execute(array $parameters, Interpreter $interpreter);
}