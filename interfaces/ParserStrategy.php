<?php

interface ParserStrategy {
    public function parse(string $input): Expression;
}