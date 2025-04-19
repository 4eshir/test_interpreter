<?php
require_once 'ConstantParser.php';
require_once 'FunctionCallParser.php';
require_once 'core/Expression.php';

class Parser {
    private array $_strategies;

    public function __construct() {
        $this->_strategies = [
            'constant' => new ConstantParser(),
            'function' => new FunctionCallParser($this),
        ];
    }

    public function parse(string $input): Expression {
        $input = trim($input);
        /*
        * Проверяем, начинается ли строка с открывающей скобки 
        * (у меня упорно не хотела работать регулярка)
        */
        if (substr($input, 0, 1) === '(') {
            return $this->_strategies['function']->parse(trim($input));
        } else {
            return $this->_strategies['constant']->parse(trim($input));
        }
    }
}