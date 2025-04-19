<?php

class ParserException extends Exception {
    protected $errorCode;

    public function __construct($message, $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    public function getErrorCode() {
        return $this->errorCode;
    }
}