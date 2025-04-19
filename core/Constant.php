<?php
require_once 'Expression.php';

class Constant extends Expression {
    private $_value;

    public function __construct($value) {
        $this->setValue($value);
    }

    public function getValue() {
        return $this->_value;
    }

    public function setValue($value) {
    	$this->_value = $value;
    }
}