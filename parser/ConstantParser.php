<?php
require_once 'interfaces/ParserStrategy.php';
require_once 'exceptions/parser/ConstantParserException.php';

class ConstantParser implements ParserStrategy {
    public function parse(string $input): Expression {
        if (preg_match('/^(true|false|null)$/', $input)) {
            return new Constant($input);
        } elseif (preg_match('/^"([^"]*)"$/', $input, $matches)) {
            return new Constant($matches[1]);
        } elseif (is_numeric($input)) {
            return new Constant($input + 0);
        }

        throw new ConstantParserException("Invalid constant: $input");
    }
}